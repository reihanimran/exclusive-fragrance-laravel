<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * List all orders for the authenticated user.
     */
    public function index()
    {
        $orders = Order::with(['items.product.featuredImage', 'shipping'])
            ->where('user_id', Auth::id())
            ->orderBy('order_date', 'desc')
            ->paginate(10);

        return response()->json($orders);
    }

    /**
     * Show a single order for the authenticated user.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->load([
            'items.product.featuredImage',
            'items.product.category',
            'shipping'
        ]);

        return response()->json($order);
    }

    /**
     * Cancel a pending order and restore product stock.
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->order_status !== 'pending') {
            return response()->json(['message' => 'Order cannot be cancelled at this stage.'], 400);
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->increment('stock_quantity', $item->quantity);
            }

            $order->update(['order_status' => 'cancelled']);
        });

        return response()->json(['message' => 'Order cancelled successfully.']);
    }

    /**
     * Download order invoice as PDF.
     */
    public function invoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->load([
            'items.product',
            'shipping',
            'user'
        ]);

        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        $fileName = "invoice-{$order->order_id}.pdf";

        Storage::disk('public')->put("invoices/{$fileName}", $pdf->output());

        return response()->json([
            'message' => 'Invoice generated successfully.',
            'invoice_url' => asset("storage/invoices/{$fileName}")
        ]);
    }
}
