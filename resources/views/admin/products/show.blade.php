<x-admin-layout>
    <x-slot name="title">Product Details</x-slot>
    <x-slot name="header">Product Details</x-slot>

    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.products.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition duration-300">
            ← Back to Products
        </a>
        <div class="flex space-x-2">
            <a href="{{ route('admin.products.edit', $product->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition duration-300">
                <i class="fas fa-edit mr-2"></i>Edit Product
            </a>
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition duration-300"
                    onclick="return confirm('Are you sure you want to delete this product?')">
                    <i class="fas fa-trash mr-2"></i>Delete Product
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Product Header -->
        <div class="p-6 bg-gray-50 border-b">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $product->product_name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Product ID: #{{ $product->id }}</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-green-600">LKR {{ number_format($product->sale_price, 2) }}</div>
                    @if($product->original_price != $product->sale_price)
                        <div class="text-sm text-gray-500 line-through">LKR {{ number_format($product->original_price, 2) }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Product Images</h3>
                    <div class="space-y-4">
                        @if($product->featuredImage)
                            <div class="border rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Featured Image</h4>
                                <img src="{{ asset('storage/' . $product->featuredImage->image_path) }}" 
                                     alt="{{ $product->product_name }}" 
                                     class="w-full h-64 object-cover rounded-lg">
                            </div>
                        @endif
                        
                        @if($product->images && $product->images->count() > 0)
                            <div class="border rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Additional Images</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($product->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="{{ $product->product_name }}" 
                                             class="w-full h-32 object-cover rounded-lg">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Details -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Product Information</h3>
                    <div class="space-y-4">
                        <!-- Basic Info -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Brand</label>
                                    <p class="text-gray-900">{{ $product->brand ?? 'No Brand' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Category</label>
                                    <p class="text-gray-900">{{ $product->category->category_name ?? 'No Category' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Fragrance Type</label>
                                    <p class="text-gray-900">{{ $product->fragrance_type ?? 'No Fragrance Type' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Stock Quantity</label>
                                    <p class="{{ $product->stock_quantity <= 0 ? 'text-red-600' : ($product->stock_quantity < 20 ? 'text-yellow-600' : 'text-green-600') }} font-semibold">
                                        {{ $product->stock_quantity }}
                                        @if($product->stock_quantity <= 0)
                                            (Out of Stock)
                                        @elseif($product->stock_quantity < 20)
                                            (Low Stock)
                                        @else
                                            (In Stock)
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Pricing</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Original Price</label>
                                    <p class="text-gray-900">LKR {{ number_format($product->original_price, 2) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Sale Price</label>
                                    <p class="text-green-600 font-semibold">LKR {{ number_format($product->sale_price, 2) }}</p>
                                </div>
                            </div>
                            @if($product->original_price != $product->sale_price)
                                <div class="mt-2">
                                    <span class="text-sm text-red-600 font-medium">
                                        Discount: {{ round((($product->original_price - $product->sale_price) / $product->original_price) * 100, 1) }}%
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Timestamps -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Timestamps</h4>
                            <div class="space-y-2">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Created At</label>
                                    <p class="text-gray-900">{{ $product->created_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Last Updated</label>
                                    <p class="text-gray-900">{{ $product->updated_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($product->description)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Description</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                </div>
            @endif

            <!-- Additional Information -->
            @if($product->specifications || $product->ingredients)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Additional Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($product->specifications)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Specifications</h4>
                                <p class="text-gray-700 whitespace-pre-line">{{ $product->specifications }}</p>
                            </div>
                        @endif
                        @if($product->ingredients)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Ingredients</h4>
                                <p class="text-gray-700 whitespace-pre-line">{{ $product->ingredients }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>