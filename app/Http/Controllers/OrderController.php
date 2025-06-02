<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;



class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Order::with(['items.product.featuredImage', 'shipping'])
            ->where('user_id', Auth::id())
            ->orderBy('order_date', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure the authenticated user can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load([
            'items.product.featuredImage',
            'items.product.category',
            'shipping'
        ]);

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order if it's still in pending status
     */
    public function cancel(Request $request, Order $order)
    {
        // Ensure the authenticated user can only cancel their own orders
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // Only allow cancellation of pending orders
        if ($order->order_status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be cancelled at this stage.'
            ], 400);
        }

        // Start transaction to revert stock and cancel order
        DB::transaction(function () use ($order) {
            // Return stock to products
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->increment('stock_quantity', $item->quantity);
            }

            // Update order status to cancelled
            $order->update(['order_status' => 'cancelled']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Order has been cancelled successfully.'
        ]);
    }

    /**
     * Download invoice for an order
     */
    public function invoice(Order $order)
    {
        // Ensure the authenticated user can only download their own invoices
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load([
            'items.product',
            'shipping',
            'user'
        ]);

        $pdf = Pdf::loadView('orders.invoice', compact('order'));

        return $pdf->download("invoice-{$order->order_id}.pdf");
    }

    /**
     * Display a listing of all orders for admin.
     */
    public function adminIndex()
    {
        $orders = Order::with(['user', 'items.product', 'shipping'])
            ->orderBy('order_date', 'desc')
            ->paginate(15);

        // Add any analytics you might want here
        $orderStats = [
            'pending' => Order::where('order_status', 'pending')->count(),
            'completed' => Order::where('order_status', 'completed')->count(),
            'cancelled' => Order::where('order_status', 'cancelled')->count(),
            'total_sales' => Order::where('order_status', 'completed')->sum('total_sale_amount'),
        ];

        return view('admin.orders.index', compact('orders', 'orderStats'));
    }

    /**
     * Display the specified order for admin.
     */
    public function adminShow($id)
    {
        $order = Order::findOrFail($id);
        
        $order->load([
            'user',
            'items.product.featuredImage',
            'items.product.category',
            'shipping'
        ]);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of an order (admin only).
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Processing,Completed,Cancelled',
        ]);

        $order = Order::findOrFail($id);

        // If changing to cancelled, return stock
        if ($validated['status'] === 'cancelled' && $order->order_status !== 'cancelled') {
            DB::transaction(function () use ($order) {
                // Return stock to products
                foreach ($order->items as $item) {
                    $product = $item->product;
                    $product->increment('stock_quantity', $item->quantity);
                }

                $order->update(['order_status' => 'cancelled']);
            });

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order cancelled and stock returned.');
        }

        // For other status changes
        $order->update(['order_status' => $validated['status']]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully.');
    }
}