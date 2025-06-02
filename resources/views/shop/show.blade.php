{{-- resources/views/shop/show.blade.php --}}
<x-app-layout>
    <x-slot name="title">{{ $product->product_name }} - Exclusive Fragrance</x-slot>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 bg-[#151E25]">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div class="flex flex-col gap-4">
                <!-- Main Image Container with Arrows -->
                <div class="relative w-full h-96 bg-gray-800 rounded-lg flex items-center justify-center">
                    <!-- Main Image -->
                    <img id="main-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                        alt="{{ $product->product_name }}" class="w-full h-full object-contain">

                    <!-- Left Arrow -->
                    <button id="prev-btn"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-opacity">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <!-- Right Arrow -->
                    <button id="next-btn"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-opacity">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Thumbnails for Other Images -->
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $index => $image)
                        <div class="w-full h-24 bg-gray-800 rounded-lg flex items-center justify-center cursor-pointer"
                            onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}')">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->product_name }}"
                                class="w-full h-full object-contain">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Details -->
            <div class="text-white">
                <h1 class="text-4xl font-bold mb-4">{{ $product->product_name }}</h1>
                <p class="text-2xl text-[#F5D57A] mb-4">Rs
                    {{ number_format($product->sale_price ?? $product->original_price, 2) }}
                </p>
                <p class="text-gray-400 mb-4">{{ $product->product_desc }}</p>

                <!-- Stock Quantity -->
                <div class="mb-4">
                    <span class="text-lg">Stock: </span>
                    <span
                        class="text-lg font-bold {{ $product->stock_quantity > 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>

                <!-- Quantity Selector -->
                <div class="mb-4">
                    <label for="quantity" class="block text-lg mb-2">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock_quantity }}"
                        value="1" class="w-24 px-3 py-2 bg-gray-800 text-white rounded-md" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                </div>

                <!-- Add to Cart Button -->
               <button
    class="add-to-cart-main w-full bg-[#F5D57A] text-black px-6 py-3 rounded-md transition-colors 
           {{ $product->stock_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-[#e0c060]' }}"
    {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
    Add to Cart
</button>

            </div>
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-white mb-8">Related Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="border border-[#F5D57A] rounded-lg p-4 flex flex-col items-center">
                            <a href="{{ route('shop.show', $related->id) }}" class="block w-full">
                                <img src="{{ asset('storage/' . $related->featuredImage?->image_path) }}" alt="{{ $related->product_name }}"
                                    class="w-full h-48 object-contain mb-4">
                                <h3 class="text-white text-center font-bold mb-2">
                                    {{ $related->product_name }}
                                </h3>
                                <p class="text-white mb-4">Rs
                                    {{ number_format($related->sale_price ?? $related->original_price, 2) }}
                                </p>
                            </a>

                            <div class="flex gap-4 w-full">
                                <button data-product-id="{{ $related->id }}"
                                    class="add-to-cart-related flex-1 bg-[#F5D57A] border-2 border-[#F5D57A] text-[#151E25] px-6 py-2 rounded-md hover:bg-opacity-90 transition-colors"
                                    {{ $related->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        @include('components.add-to-cart-script')
        <script>
            // Array of all product images
            const images = [
                @foreach($product->images as $image)
                    "{{ asset('storage/' . $image->image_path) }}",
                @endforeach
                    ];

            let currentImageIndex = 0;

            // Image gallery functions
            function changeMainImage(newSrc) {
                document.getElementById('main-image').src = newSrc;
                currentImageIndex = images.indexOf(newSrc);
            }

            document.getElementById('prev-btn').addEventListener('click', () => {
                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                changeMainImage(images[currentImageIndex]);
            });

            document.getElementById('next-btn').addEventListener('click', () => {
                currentImageIndex = (currentImageIndex + 1) % images.length;
                changeMainImage(images[currentImageIndex]);
            });

            // Main product button handler
            document.querySelector('.add-to-cart-main').addEventListener('click', function () {
                const quantity = document.getElementById('quantity').value;
                addToCart({{ $product->id }}, quantity);
            });

            // Related products handlers
            document.querySelectorAll('.add-to-cart-related').forEach(button => {
                button.addEventListener('click', function () {
                    addToCart(this.dataset.productId, 1);
                });
            });
        </script>
    @endpush
</x-app-layout>