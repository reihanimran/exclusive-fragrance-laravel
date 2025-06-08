<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
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
        $cart = $this->getActiveCart()->load(['items.product.featuredImage', 'items.product.category']);

        return response()->json([
            'cart' => $cart,
            'total' => $this->calculateTotal($cart),
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = $this->getActiveCart();
        $existingQty = $cart->items()->where('product_id', $product->id)->value('quantity') ?? 0;
        $newQty = $existingQty + $request->quantity;

        if ($newQty > $product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available',
            ], 400);
        }

        DB::transaction(function () use ($cart, $product, $newQty) {
            $item = $cart->items()->firstOrCreate(
                ['product_id' => $product->id],
                ['quantity' => 0]
            );
            $item->update(['quantity' => $newQty]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => $this->getCartCount(),
        ]);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);

        if ($request->quantity > $cartItem->product->stock_quantity) {
            return response()->json(['message' => 'Not enough stock'], 400);
        }

        if ($request->quantity == 0) {
            $cartItem->delete();
        } else {
            $cartItem->update(['quantity' => $request->quantity]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'total' => $this->calculateTotal($this->getActiveCart()),
        ]);
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'total' => $this->calculateTotal($this->getActiveCart()),
        ]);
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
        $cart = $this->getActiveCart()->load(['items.product.featuredImage', 'items.product.category']);

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
            }),
        ]);
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
    public function checkout()
    {
        $cart = $this->getActiveCart()->load(['items.product.featuredImage', 'items.product.category']);

        $shippingDetails = Shipping::where('user_id', Auth::id())->first();
        $cartTotal = $this->calculateTotal($cart);
        $shippingCost = 500.00;
        $grandTotal = $cartTotal + $shippingCost;

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
            }),
            'cart_total' => $cartTotal,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'shipping_details' => $shippingDetails,
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
            'payment_method' => 'required|in:credit_card,paypal,cod',
        ]);

        $order = null;

        DB::transaction(function () use ($request, &$order) {
            $cart = $this->getActiveCart()->load('items.product');

            // Check stock availability
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock_quantity) {
                    throw new \Exception("Not enough stock for {$item->product->product_name}");
                }
            }

            // Save or update shipping
            $shipping = Shipping::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'full_name' => $request->full_name,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'phone' => $request->phone,
                ]
            );

            $totals = $this->calculateOrderTotals($cart);

            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping_id' => $shipping->id,
                'order_status' => 'pending',
                'total_sale_amount' => $totals['sale_total'],
                'total_order_amount' => $totals['original_total'],
                'order_date' => now(),
                'payment_method' => $request->payment_method
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'original_item_price' => $item->product->original_price,
                    'sale_item_price' => $item->product->sale_price,
                    'item_discount' => $item->product->original_price - $item->product->sale_price,
                ]);

                // Reduce stock
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // Mark cart as completed
            $cart->update(['cart_status' => 'completed']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order_id' => $order->id,
        ]);
    }

    private function calculateOrderTotals(Cart $cart)
    {
        return $cart->items->reduce(function ($totals, $item) {
            $totals['original_total'] += $item->product->original_price * $item->quantity;
            $totals['sale_total'] += ($item->product->sale_price ?? $item->product->original_price) * $item->quantity;
            return $totals;
        }, ['original_total' => 0, 'sale_total' => 0]);
    }
}
