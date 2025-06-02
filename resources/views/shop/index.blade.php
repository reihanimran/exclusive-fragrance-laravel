<x-app-layout>
    <x-slot name="title">Shop - Exclusive Fragrance</x-slot>

    <!-- Hero Banner -->
    <div class="relative w-full h-[40vh] flex items-center justify-center">
        <div class="absolute inset-0">
            <img src="{{ asset('uploads/banners/shop-bg.jpg') }}" alt="Luxury Fragrance Collection" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-heading">EXCLUSIVE FRAGRANCE COLLECTION</h1>
            <p class="text-xl text-[#F5D57A] max-w-2xl mx-auto">Discover our curated selection of premium scents crafted for the discerning individual</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 bg-[#151E25]">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Mobile Filter Button -->
            <button id="filterToggle" class="lg:hidden bg-[#F5D57A] text-[#151E25] px-4 py-2 rounded-md mb-4 flex items-center justify-center">
                <i class="fas fa-filter mr-2"></i> Filters
            </button>

            <!-- Sidebar Filters -->
            <div id="filterSidebar" class="w-full lg:w-1/4 bg-[#1e293b] p-6 rounded-lg shadow-lg">
                <form id="filterForm" method="GET" action="{{ route('shop.index') }}">
                    <!-- Price Range -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center cursor-pointer" onclick="toggleAccordion('price')">
                            <h3 class="text-xl font-semibold text-[#F5D57A]">PRICE RANGE</h3>
                            <svg id="price-arrow" class="w-6 h-6 text-[#F5D57A] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div id="price-content" class="mt-4">
                            <div class="mb-4">
                                <div class="flex justify-between text-white mb-2">
                                    <span>LKR {{ number_format($filterData['priceRange']['min']) }}</span>
                                    <span>LKR {{ number_format($filterData['priceRange']['max']) }}</span>
                                </div>
                                <input type="range" min="{{ $filterData['priceRange']['min'] }}" max="{{ $filterData['priceRange']['max'] }}" 
                                    value="{{ request('max_price', $filterData['priceRange']['max']) }}" 
                                    class="w-full accent-[#F5D57A]" id="priceRange">
                            </div>
                            
                            <button type="button" onclick="applyPriceFilter()"
                                class="w-full mt-4 bg-[#F5D57A] hover:bg-[#e0c060] text-[#151E25] py-2 px-4 rounded-md transition-colors">
                                Apply Price
                            </button>
                        </div>
                        <div class="w-full h-px bg-[#F5D57A] my-4"></div>
                    </div>

                    <!-- Categories -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center cursor-pointer" onclick="toggleAccordion('categories')">
                            <h3 class="text-xl font-semibold text-[#F5D57A]">CATEGORIES</h3>
                            <svg id="categories-arrow" class="w-6 h-6 text-[#F5D57A] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div id="categories-content" class="mt-4 hidden">
                            <div class="space-y-2">
                                @foreach($filterData['categories'] as $category)
                                    <label class="flex items-center text-white">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                            class="mr-2 accent-[#F5D57A]"
                                            @if(in_array($category->id, $selectedCategories)) checked @endif>
                                        {{ $category->name }} ({{ $category->products_count }})
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="w-full h-px bg-[#F5D57A] my-4"></div>
                    </div>

                    <!-- Fragrance Type -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center cursor-pointer" onclick="toggleAccordion('fragrance')">
                            <h3 class="text-xl font-semibold text-[#F5D57A]">FRAGRANCE TYPE</h3>
                            <svg id="fragrance-arrow" class="w-6 h-6 text-[#F5D57A] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div id="fragrance-content" class="mt-4 hidden">
                            <div class="space-y-2">
                                @foreach($filterData['fragranceTypes'] as $type)
                                    <label class="flex items-center text-white">
                                        <input type="checkbox" name="fragrance_type[]" value="{{ $type }}" 
                                            class="mr-2 accent-[#F5D57A]"
                                            @if(in_array($type, request('fragrance_type', []))) checked @endif>
                                        {{ $type }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="w-full h-px bg-[#F5D57A] my-4"></div>
                    </div>

                    <!-- Size -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center cursor-pointer" onclick="toggleAccordion('size')">
                            <h3 class="text-xl font-semibold text-[#F5D57A]">SIZE</h3>
                            <svg id="size-arrow" class="w-6 h-6 text-[#F5D57A] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div id="size-content" class="mt-4 hidden">
                            <div class="space-y-2">
                                @foreach($filterData['sizes'] as $size)
                                    <label class="flex items-center text-white">
                                        <input type="checkbox" name="size[]" value="{{ $size }}" 
                                            class="mr-2 accent-[#F5D57A]"
                                            @if(in_array($size, request('size', []))) checked @endif>
                                        {{ $size }}ml
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="w-full h-px bg-[#F5D57A] my-4"></div>
                    </div>

                    <!-- Gender -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center cursor-pointer" onclick="toggleAccordion('gender')">
                            <h3 class="text-xl font-semibold text-[#F5D57A]">GENDER</h3>
                            <svg id="gender-arrow" class="w-6 h-6 text-[#F5D57A] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div id="gender-content" class="mt-4 hidden">
                            <div class="space-y-2">
                                @foreach($filterData['genders'] as $gender)
                                    <label class="flex items-center text-white">
                                        <input type="checkbox" name="gender[]" value="{{ $gender }}" 
                                            class="mr-2 accent-[#F5D57A]"
                                            @if(in_array($gender, request('gender', []))) checked @endif>
                                        {{ $gender }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="w-full h-px bg-[#F5D57A] my-4"></div>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center cursor-pointer" onclick="toggleAccordion('stock')">
                            <h3 class="text-xl font-semibold text-[#F5D57A]">STOCK STATUS</h3>
                            <svg id="stock-arrow" class="w-6 h-6 text-[#F5D57A] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div id="stock-content" class="mt-4 hidden">
                            <div class="space-y-2">
                                <label class="flex items-center text-white">
                                    <input type="checkbox" name="stock_status" value="in_stock" 
                                        class="mr-2 accent-[#F5D57A]"
                                        @if(request('stock_status') === 'in_stock') checked @endif>
                                    In Stock
                                </label>
                                <label class="flex items-center text-white">
                                    <input type="checkbox" name="bestseller" value="1" 
                                        class="mr-2 accent-[#F5D57A]"
                                        @if(request('bestseller')) checked @endif>
                                    Bestsellers
                                </label>
                            </div>
                        </div>
                        <div class="w-full h-px bg-[#F5D57A] my-4"></div>
                    </div>

                    <!-- Sorting -->
                    <div class="mb-4">
                        <label class="block text-xl font-semibold text-[#F5D57A] mb-2">SORT BY</label>
                        <select name="sort" class="w-full px-3 py-2 bg-[#151E25] border border-gray-600 rounded text-white">
                            <option value="latest" @if(request('sort', 'latest') === 'latest') selected @endif>Newest Arrivals</option>
                            <option value="price_asc" @if(request('sort') === 'price_asc') selected @endif>Price: Low to High</option>
                            <option value="price_desc" @if(request('sort') === 'price_desc') selected @endif>Price: High to Low</option>
                            <option value="name_asc" @if(request('sort') === 'name_asc') selected @endif>Name: A to Z</option>
                            <option value="name_desc" @if(request('sort') === 'name_desc') selected @endif>Name: Z to A</option>
                        </select>
                    </div>

                    <!-- Submit and Reset Buttons -->
                    <div class="flex space-x-4 mt-6">
                        <button type="submit" class="flex-1 bg-[#F5D57A] hover:bg-[#e0c060] text-[#151E25] py-2 px-4 rounded-md transition-colors">
                            Apply Filters
                        </button>
                        <a href="{{ route('shop.index') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md text-center transition-colors">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="w-full lg:w-3/4">
                <!-- Filter summary and sorting -->
                <div class="bg-[#1e293b] rounded-lg p-4 mb-6 flex flex-col md:flex-row justify-between items-center">
                    <div class="text-white mb-4 md:mb-0">
                        <p>Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} products</p>
                        @if(request()->anyFilled(['categories', 'fragrance_type', 'size', 'gender', 'min_price', 'max_price']))
                            <p class="text-sm text-[#F5D57A] mt-1">Active filters applied</p>
                        @endif
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-white">View:</span>
                        <select class="bg-[#151E25] border border-gray-600 rounded text-white px-3 py-2" onchange="window.location.href = '?limit=' + this.value">
                            <option value="12" @if(request('limit', 12) == 12) selected @endif>12 per page</option>
                            <option value="24" @if(request('limit') == 24) selected @endif>24 per page</option>
                            <option value="48" @if(request('limit') == 48) selected @endif>48 per page</option>
                        </select>
                    </div>
                </div>

                <!-- Products -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="border border-[#F5D57A] rounded-lg p-4 flex flex-col items-center">
                                <div class="relative">
                                    <a href="{{ route('shop.show', $product->id) }}">
                                        <img src="{{ $product->featuredImage?->image_path ? asset('storage/' . $product->featuredImage->image_path) : asset('uploads/images/default-placeholder.png') }}" 
                                            alt="{{ $product->product_name }}" 
                                            class="w-full object-cover">
                                    </a>
                                    @if($product->stock_quantity <= 0)
                                        <div class="absolute top-4 right-4 bg-red-600 text-white text-xs px-2 py-1 rounded">
                                            Sold Out
                                        </div>
                                    @elseif($product->Bestseller)
                                        <div class="absolute top-0 right-0 bg-[#F5D57A] text-[#151E25] text-xs px-2 py-1 rounded">
                                            Bestseller
                                        </div>
                                    @endif
                                </div>
                                <div class="py-4 px-2 self-start w-full">
                                    <div class="flex flex-col justify-between items-start mb-2">
                                        <a href="{{ route('shop.show', $product->id) }}" class="text-white font-semibold hover:text-[#F5D57A] transition-colors">
                                            {{ $product->product_name }}
                                        </a>
                                        <span class="text-[#F5D57A] font-bold">
                                            LKR {{ number_format($product->sale_price ?? $product->original_price, 2) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-400 text-sm mb-4">{{ $product->category->name }}</p>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-300">{{ $product->size }}</span>
                                        <span class="text-sm text-gray-300">{{ $product->gender }}</span>
                                    </div>                                 
                                    
                                </div>
                                <button onclick="addToCart({{ $product->id }}, 1)"
                                        class="w-full add-to-cart flex-1 bg-[#F5D57A] border-2 border-[#F5D57A] text-[#151E25] px-6 py-2 rounded-md hover:bg-opacity-90 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                        @if($product->stock_quantity <= 0) disabled @endif>
                                        @if($product->stock_quantity <= 0)
                                            Out of Stock
                                        @else
                                            <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                        @endif
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-[#1e293b] rounded-lg">
                        <i class="fas fa-box-open text-5xl text-[#F5D57A] mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">No Products Found</h3>
                        <p class="text-gray-400 mb-6">Try adjusting your filters to find what you're looking for</p>
                        <a href="{{ route('shop.index') }}" class="bg-[#F5D57A] hover:bg-[#e0c060] text-[#151E25] py-2 px-6 rounded-md font-medium inline-block transition-colors">
                            Reset Filters
                        </a>
                    </div>
                @endif

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Accordion toggle function
        function toggleAccordion(section) {
            const content = document.getElementById(`${section}-content`);
            const arrow = document.getElementById(`${section}-arrow`);
            
            content.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        // Price range filter
        function applyPriceFilter() {
            const minPrice = document.getElementById('minPrice').value;
            const maxPrice = document.getElementById('maxPrice').value;
            
            document.getElementById('filterForm').submit();
        }

        </script>
        @include('components.add-to-cart-script')
    @endpush
</x-app-layout>