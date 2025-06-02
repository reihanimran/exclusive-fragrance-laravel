<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use Str;

class ProductController extends Controller
{
    public function adminIndex()
    {
        $products = Product::with('category')->paginate(15);
        $categories = Category::all();
        $ordersCount = Order::count();
        $recentOrders = Order::latest()->take(10)->with('user')->get();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'ordersCount',
            'recentOrders'
        ));
    }
    public function adminShow($id)
    {
        try {
            // Find the product with related models
            $product = Product::with([
                'category',
                'featuredImage',
                'images'
            ])->findOrFail($id);

            return view('admin.products.show', compact('product'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Product not found.');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'An error occurred while loading the product.');
        }
    }
    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'fragrance_type' => 'required|string|max:255',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'product_desc' => 'required|string',
            'size' => 'required|string|max:50',
            'gender' => 'required|string|in:M,F,U',
            'bestseller' => 'nullable|boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Create the product
        $product = Product::create([
            'product_name' => $validated['product_name'],
            'brand' => $validated['brand'],
            'fragrance_type' => $validated['fragrance_type'],
            'original_price' => $validated['original_price'],
            'sale_price' => $validated['sale_price'],
            'stock_quantity' => $validated['stock_quantity'],
            'category_id' => $validated['category_id'],
            'product_desc' => $validated['product_desc'],
            'size' => $validated['size'],
            'gender' => $validated['gender'],
            'Bestseller' => $request->has('bestseller'),
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $this->processProductImages($request->file('images'), $product->id);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'fragrance_type' => 'required|string|max:255',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'product_desc' => 'required|string',
            'size' => 'required|string|max:50',
            'gender' => 'required|string|in:M,F,U',
            'bestseller' => 'nullable|boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update the product
        $product->update([
            'product_name' => $validated['product_name'],
            'brand' => $validated['brand'],
            'fragrance_type' => $validated['fragrance_type'],
            'original_price' => $validated['original_price'],
            'sale_price' => $validated['sale_price'],
            'stock_quantity' => $validated['stock_quantity'],
            'category_id' => $validated['category_id'],
            'product_desc' => $validated['product_desc'],
            'size' => $validated['size'],
            'gender' => $validated['gender'],
            'Bestseller' => $request->input('bestseller', 0), // Will be 0 or 1
        ]);

        // Handle image uploads if new images are provided
        if ($request->hasFile('images')) {
            // Delete old images if needed
            $this->deleteProductImages($product->$id);

            // Process new images
            $this->processProductImages($request->file('images'), $product->$id);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Process and store product images
     */
    private function processProductImages($images, $id)
    {
        $product = Product::findOrFail($id);

        $productDir = "uploads/products/{$product->id}";

        Storage::disk('public')->makeDirectory($productDir);


        foreach ($images as $index => $image) {
            $isFeatured = $index === 0; // First image is featured

            // Generate filename
            $extension = $image->getClientOriginalExtension();
            $filename = $isFeatured ? "featured.{$extension}" : Str::random(13) . ".{$extension}";

            // Store the original image
            $path = $image->storeAs($productDir, $filename, 'public');

            // Save to database
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_featured' => (int) $isFeatured, // Explicit cast to 0 or 1
                'alt_text' => "{$product->product_name} product image"
            ]);
        }
    }

    /**
     * Delete product images from storage
     */
    private function deleteProductImages($id)
    {
        
        $product = Product::findOrFail($id);

        $productDir = "uploads/products/{$product->id}";

        Storage::disk('public')->delete($productDir);

        // Delete database records
        $product->images()->delete();
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->orderItems()->count() > 0) {
            return redirect()->route('admin.products.index')->with('Failed', 'Cannot delete product');
        }       
        $this->deleteProductImages($product->id);

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}