<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Return filtered and paginated product list for the API.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])
            ->when($request->filled('gender'), fn($q) => $q->whereIn('gender', explode(',', $request->gender)))
            ->when($request->filled('categories'), fn($q) => $q->whereIn('category_id', explode(',', $request->categories)))
            ->when($request->filled('fragrance_type'), fn($q) => $q->whereIn('fragrance_type', explode(',', $request->fragrance_type)))
            ->when($request->filled('size'), fn($q) => $q->whereIn('size', explode(',', $request->size)))
            ->when($request->filled('min_price') || $request->filled('max_price'), fn($q) => 
                $q->whereBetween('sale_price', [
                    $request->min_price ?? 0,
                    $request->max_price ?? Product::max('sale_price')
                ])
            )
            ->when($request->filled('stock_status'), fn($q) =>
                $request->stock_status === 'in_stock'
                    ? $q->where('stock_quantity', '>', 0)
                    : $q->where('stock_quantity', '<=', 0)
            )
            ->when($request->filled('bestseller'), fn($q) => $q->where('Bestseller', true));

        $sortOptions = [
            'latest' => ['created_at', 'desc'],
            'price_asc' => ['sale_price', 'asc'],
            'price_desc' => ['sale_price', 'desc'],
            'name_asc' => ['product_name', 'asc'],
            'name_desc' => ['product_name', 'desc'],
        ];

        $sort = $sortOptions[$request->input('sort', 'latest')] ?? $sortOptions['latest'];
        $query->orderBy($sort[0], $sort[1]);

        $products = $query->paginate($request->input('limit', 12))->appends($request->query());

        return response()->json([
            'products' => $products
        ]);
    }

    /**
     * Return single product with images and related products.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $product->load('images', 'category');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->take(4)
            ->get();

        return response()->json([
            'product' => $product,
            'related_products' => $relatedProducts
        ]);
    }
}
