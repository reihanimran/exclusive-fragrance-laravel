<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
            'featured_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $category = Category::create($validated);

        // Process image if uploaded
        if ($request->hasFile('featured_img')) {
            $this->processCategoryImage($request->file('featured_img'), $category->id);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name,' . $id,
            'description' => 'nullable|string',
            'featured_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $category = Category::findOrFail($id);

        // Handle image update
        if ($request->hasFile('featured_img')) {
            // Delete existing image
            $this->deleteCategoryImage($category->id);
            // Process new image
            $this->processCategoryImage($request->file('featured_img'), $category->id);
        }

        // Only update name and description
        $category->update([
            'category_name' => $validated['category_name'],
            'description' => $validated['description'] ?? null,
        ]);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Check for associated products
        if ($category->products()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with associated products.');
        }

        // Delete category image
        $this->deleteCategoryImage($category->id);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Process and store category image
     */
    private function processCategoryImage($image, $id)
    {
        $category = Category::findOrFail($id);

        $dir = 'uploads/categories';
        Storage::disk('public')->makeDirectory($dir);

        // Generate unique filename
        $extension = $image->getClientOriginalExtension();
        $filename = Str::slug($category->category_name) . '-' . uniqid() . '.' . $extension;

        // Store image
        $path = $image->storeAs($dir, $filename, 'public');

        // Update category with image path
        $category->update(['featured_img' => $path]);
    }

    /**
     * Delete category image from storage
     */
    private function deleteCategoryImage($id)
    {
        $category = Category::findOrFail($id);

        if ($category->featured_img) {
            // Delete image file
            Storage::disk('public')->delete($category->featured_img);

            // Clear image reference
            // $category->update(['featured_img' => null]); This is optional
        }
    }
}