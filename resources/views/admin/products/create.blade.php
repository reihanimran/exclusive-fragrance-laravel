<x-admin-layout>
    <x-slot name="title">Create Product</x-slot>
    <x-slot name="header">Create New Product</x-slot>

    <div class="glass-panel rounded-xl overflow-hidden">
        <div class="p-6 md:p-8">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm text-gray-600 mb-6">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-gold">Dashboard</a>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <a href="{{ route('admin.products.index') }}" class="hover:text-gold">Products</a>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <span class="text-primary font-medium">Create Product</span>
            </div>

            <!-- Product Form -->
            <form action="{{ route('admin.products.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Product Name -->
                    <div>
                        <label for="product_name" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-tag perfume-icon mr-2"></i>
                            Product Name
                        </label>
                        <input type="text" id="product_name" name="product_name"
                            value="{{ old('product_name') }}" required
                            class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                        @error('product_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-copyright perfume-icon mr-2"></i>
                            Brand
                        </label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}" required
                            class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                        @error('brand')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fragrance Type -->
                    <div>
                        <label for="fragrance_type" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-wind perfume-icon mr-2"></i>
                            Fragrance Type
                        </label>
                        <select id="fragrance_type" name="fragrance_type" required
                            class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                            <option value="">Select Type</option>
                            <option value="Woody Aromatic" {{ old('fragrance_type') == 'Woody Aromatic' ? 'selected' : '' }}>Woody Aromatic</option>
                            <option value="Floral" {{ old('fragrance_type') == 'Floral' ? 'selected' : '' }}>Floral</option>
                            <option value="Fresh Spicy" {{ old('fragrance_type') == 'Fresh Spicy' ? 'selected' : '' }}>Fresh Spicy</option>
                            <option value="Oriental Vanilla" {{ old('fragrance_type') == 'Oriental Vanilla' ? 'selected' : '' }}>Oriental Vanilla
                            </option>
                            <option value="Aromatic Fougere" {{ old('fragrance_type') == 'Aromatic Fougere' ? 'selected' : '' }}>Aromatic Fougere
                            </option>
                            <option value="Citrus" {{ old('fragrance_type') == 'Citrus' ? 'selected' : '' }}>Citrus</option>
                            <option value="Oriental Floral" {{ old('fragrance_type') == 'Oriental Floral' ? 'selected' : '' }}>Oriental Floral
                            </option>
                            <option value="Fruity Chypre" {{ old('fragrance_type') == 'Fruity Chypre' ? 'selected' : '' }}>Fruity Chypre</option>
                            <option value="Aldehydic Floral" {{ old('fragrance_type') == 'Aldehydic Floral' ? 'selected' : '' }}>Aldehydic Floral
                            </option>
                            <option value="Woody Spicy" {{ old('fragrance_type') == 'Woody Spicy' ? 'selected' : '' }}>Woody Spicy</option>
                            <option value="Spicy Leather" {{ old('fragrance_type') == 'Spicy Leather' ? 'selected' : '' }}>Spicy Leather</option>
                            <option value="Chypre Fruity" {{ old('fragrance_type') == 'Chypre Fruity' ? 'selected' : '' }}>Chypre Fruity</option>
                        </select>
                        @error('fragrance_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-list perfume-icon mr-2"></i>
                            Category
                        </label>
                        <select id="category_id" name="category_id" required
                            class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Original Price -->
                    <div>
                        <label for="original_price" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-tag perfume-icon mr-2"></i>
                            Original Price (LKR)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rs.</span>
                            <input type="number" id="original_price" name="original_price"
                                value="{{ old('original_price') }}" step="0.01" min="0"
                                required
                                class="input-field w-full pl-8 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                        </div>
                        @error('original_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Price -->
                    <div>
                        <label for="sale_price" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-percentage perfume-icon mr-2"></i>
                            Sale Price (LKR)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rs.</span>
                            <input type="number" id="sale_price" name="sale_price"
                                value="{{ old('sale_price') }}" step="0.01" min="0"
                                class="input-field w-full pl-8 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                        </div>
                        @error('sale_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Quantity -->
                    <div>
                        <label for="stock_quantity" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-boxes perfume-icon mr-2"></i>
                            Stock Quantity
                        </label>
                        <input type="number" id="stock_quantity" name="stock_quantity"
                            value="{{ old('stock_quantity') }}" min="0" required
                            class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                        @error('stock_quantity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Size -->
                    <div>
                        <label for="size" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-weight perfume-icon mr-2"></i>
                            Size (ml)
                        </label>
                        <select id="size" name="size" required
                            class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                            <option value="">Select Size</option>
                            <option value="30ml" {{ old('size') == '30ml' ? 'selected' : '' }}>30ml
                            </option>
                            <option value="50ml" {{ old('size') == '50ml' ? 'selected' : '' }}>50ml
                            </option>
                            <option value="75ml" {{ old('size') == '75ml' ? 'selected' : '' }}>75ml
                            </option>
                            <option value="100ml" {{ old('size') == '100ml' ? 'selected' : '' }}>100ml
                            </option>
                            <option value="150ml" {{ old('size') == '150ml' ? 'selected' : '' }}>150ml
                            </option>
                        </select>
                        @error('size')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-venus-mars perfume-icon mr-2"></i>
                            Gender
                        </label>
                        <select id="gender" name="gender" required
                            class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                            <option value="">Select Gender</option>
                            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Men
                            </option>
                            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>
                                Female</option>
                            <option value="U" {{ old('gender') == 'U' ? 'selected' : '' }}>
                                Unisex</option>
                        </select>

                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bestseller -->
                    <div class="flex items-end">
                        <div class="checkbox-container flex items-center mt-2">
                            <!-- Hidden input to ensure unchecked value is sent -->
                            <input type="hidden" name="bestseller" value="0">

                            <input type="checkbox" id="bestseller" name="bestseller" value="1" {{ old('bestseller') ? 'checked' : '' }}>

                            <label for="bestseller" class="ml-2 flex items-center cursor-pointer">
                                <span class="checkmark"></span>
                                <span class="text-sm font-medium text-gray-700">Mark as Bestseller</span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Product Description -->
                <div class="mb-8">
                    <label for="product_desc" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-align-left perfume-icon mr-2"></i>
                        Product Description
                    </label>
                    <textarea id="product_desc" name="product_desc" rows="5" required
                        class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">{{ old('product_desc') }}</textarea>
                    @error('product_desc')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload Section -->
                <div class="mb-8">
                    <label class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-images perfume-icon mr-2"></i>
                        Product Images
                    </label>

                    <p class="text-sm text-gray-600 mb-3">Upload product images (First image will be set as featured):</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div
                            class="relative border-2 border-dashed border-gray-300 rounded-xl h-32 flex flex-col items-center justify-center cursor-pointer hover:border-gold transition-colors">
                            <input type="file" name="images[]"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                            <i class="fas fa-plus text-gray-400 text-xl mb-2"></i>
                            <span class="text-xs text-gray-500">Featured Image</span>
                        </div>
                        <div
                            class="relative border-2 border-dashed border-gray-300 rounded-xl h-32 flex items-center justify-center cursor-pointer hover:border-gold transition-colors">
                            <input type="file" name="images[]"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                            <i class="fas fa-plus text-gray-400 text-xl"></i>
                        </div>
                        <div
                            class="relative border-2 border-dashed border-gray-300 rounded-xl h-32 flex items-center justify-center cursor-pointer hover:border-gold transition-colors">
                            <input type="file" name="images[]"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                            <i class="fas fa-plus text-gray-400 text-xl"></i>
                        </div>
                        <div
                            class="relative border-2 border-dashed border-gray-300 rounded-xl h-32 flex items-center justify-center cursor-pointer hover:border-gold transition-colors">
                            <input type="file" name="images[]"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                            <i class="fas fa-plus text-gray-400 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Upload up to 4 images. First image will be set as featured.</p>
                    @error('images')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="fragrance-divider my-8"></div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <div class="perfume-badge px-4 py-3 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            <p class="text-sm">All fields are required except sale price</p>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <a href="{{ route('admin.products.index') }}"
                            class="btn-secondary px-6 py-3 rounded-lg font-medium">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary px-6 py-3 rounded-lg font-medium flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Create Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Handle bestseller checkbox
            const bestsellerCheckbox = document.getElementById('bestseller');
            const bestsellerLabel = document.querySelector('label[for="bestseller"]');

            if (bestsellerLabel) {
                bestsellerLabel.addEventListener('click', () => {
                    bestsellerCheckbox.checked = !bestsellerCheckbox.checked;
                    bestsellerLabel.querySelector('.checkmark').style.backgroundColor =
                        bestsellerCheckbox.checked ? '#d4b65a' : 'transparent';
                    bestsellerLabel.querySelector('.checkmark').style.borderColor =
                        bestsellerCheckbox.checked ? '#d4b65a' : '#c4b7a1';
                });

                // Initialize on page load
                if (bestsellerCheckbox.checked) {
                    bestsellerLabel.querySelector('.checkmark').style.backgroundColor = '#d4b65a';
                    bestsellerLabel.querySelector('.checkmark').style.borderColor = '#d4b65a';
                }
            }
        </script>
    @endpush
</x-admin-layout>