<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private function getActiveCart()
    {
        return Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'cart_status' => 'active'],
            ['cart_status' => 'active']
        );
    }

    public function index()
    {
        $cart = $this->getActiveCart()->load(['items.product.images']);
        return view('cart.index', [
            'cart' => $cart,
            'total' => $this->calculateTotal($cart)
        ]);
    }
    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = $this->getActiveCart();

        $currentQuantityInCart = $cart->items()->where('product_id', $product->id)->value('quantity') ?? 0;
        $newQuantity = $currentQuantityInCart + $request->quantity;

        if ($newQuantity > $product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        DB::transaction(function () use ($cart, $product, $request, $newQuantity) {
            $cartItem = $cart->items()->firstOrCreate(
                ['product_id' => $product->id],
                ['quantity' => 0]
            );

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        });

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => $this->getCartCount()
        ]);
    }


    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);

        DB::transaction(function () use ($cartItem, $request) {
            $product = $cartItem->product;

            // Check total requested quantity, not just diff
            if ($request->quantity > $product->stock_quantity) {
                abort(400, 'Not enough stock available');
            }

            if ($request->quantity === 0) {
                $cartItem->delete();
            } else {
                $cartItem->update(['quantity' => $request->quantity]);
            }

            // Don't decrement stock here
        });

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'total' => $this->calculateTotal($this->getActiveCart())
        ]);
    }

    public function remove(CartItem $cartItem)
    {
        DB::transaction(function () use ($cartItem) {
            $cartItem->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'total' => $this->calculateTotal($this->getActiveCart())
        ]);
    }

    // CartController.php - Updated checkout method
    public function checkout()
    {
        $cart = $this->getActiveCart()->load(['items.product.featuredImage', 'items.product.category']);

        // Get existing shipping details if available
        $shippingDetails = Shipping::where('user_id', Auth::id())->first();

        $cartTotal = $this->calculateTotal($cart);
        $shippingCost = 500.00; // Fixed shipping cost
        $grandTotal = $cartTotal + $shippingCost;

        return view('cart.checkout', [
            'cart' => $cart,
            'cartTotal' => $cartTotal,
            'shippingCost' => $shippingCost,
            'grandTotal' => $grandTotal,
            'shippingDetails' => $shippingDetails
        ]);
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:credit_card,paypal,cod'
        ]);

        $order = null;

        DB::transaction(function () use ($request, &$order) {
            $cart = $this->getActiveCart()->load('items.product');

            // Validate stock availability
            foreach ($cart->items as $cartItem) {
                if ($cartItem->quantity > $cartItem->product->stock_quantity) {
                    throw new \Exception('Not enough stock for ' . $cartItem->product->product_name);
                }
            }

            //update or create shipping address
            $shipping = Shipping::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'full_name' => $request->full_name,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'phone' => $request->phone
                ]
            );
            // Calculate Order Amounts
            $totals = $this->calculateOrderTotals($cart);

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping_id' => $shipping->id,
                'order_status' => 'pending',
                'total_sale_amount' => $totals['sale_total'],
                'total_order_amount' => $totals['original_total'],
                'order_date' => now()
            ]);

            // Create Order Items and reduce stock here
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'original_item_price' => $cartItem->product->original_price,
                    'sale_item_price' => $cartItem->product->sale_price,
                    'item_discount' => $cartItem->product->original_price - $cartItem->product->sale_price
                ]);

                // Reduce stock permanently
                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
            }

            // Mark cart as completed
            $cart->update(['cart_status' => 'completed']);
        });

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    private function calculateOrderTotals(Cart $cart)
    {
        return $cart->items->reduce(function ($totals, $item) {
            $totals['original_total'] += $item->product->original_price * $item->quantity;
            $totals['sale_total'] += ($item->product->sale_price ?? $item->product->original_price) * $item->quantity;
            return $totals;
        }, ['original_total' => 0, 'sale_total' => 0]);
    }

    private function calculateTotal(Cart $cart)
    {
        return $cart->items->sum(function ($item) {
            return ($item->product->sale_price ?? $item->product->original_price) * $item->quantity;
        });
    }

    private function getCartCount()
    {
        return $this->getActiveCart()->items()->count();
    }

    public function count()
    {
        $count = auth()->check()
            ? auth()->user()->activeCartItems()->count()
            : 0;

        return response()->json(['count' => $count]);
    }

    public function getCartItems()
    {
        $cart = $this->getActiveCart();
        $cart->load(['items.product.featuredImage', 'items.product.category']);

        return response()->json([
            'cart_items' => $cart->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->product_name,
                    'category_name' => $item->product->category->category_name,
                    'fragrance_type' => $item->product->fragrance_type,
                    'size' => $item->product->size,
                    'sale_price' => $item->product->sale_price,
                    'stock_quantity' => $item->product->stock_quantity,
                    'image_path' => $item->product->featuredImage ?
                        asset($item->product->featuredImage->image_path) :
                        asset('uploads/images/default-placeholder.png'),
                    'quantity' => $item->quantity,
                ];
            })
        ]);
    }
}
