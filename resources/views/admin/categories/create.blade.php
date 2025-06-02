<x-admin-layout>
    <div class="max-w-2xl mx-auto p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Create New Category</h1>
            <p class="text-gray-600">Add a new category to organize your content</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Category Name -->
                    <div class="mb-6">
                        <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Category Name *
                        </label>
                        <input type="text" 
                               name="category_name" 
                               id="category_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category_name') border-red-300 @enderror"
                               value="{{ old('category_name') }}" 
                               placeholder="Enter category name"
                               required>
                        @error('category_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" 
                                  id="description"
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror"
                                  placeholder="Describe this category...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-8">
                        <label for="featured_img" class="block text-sm font-medium text-gray-700 mb-2">
                            Featured Image
                        </label>
                        <div id="upload-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors @error('featured_img') border-red-300 @enderror">
                            <div id="upload-content" class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="featured_img" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                        <span>Upload a file</span>
                                        <input type="file" 
                                               name="featured_img" 
                                               id="featured_img" 
                                               class="sr-only"
                                               accept="image/jpeg,image/png,image/jpg,image/gif">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                            
                            <!-- File Selected State -->
                            <div id="file-selected" class="space-y-3 text-center hidden">
                                <div class="flex items-center justify-center">
                                    <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p id="file-name" class="text-sm font-medium text-gray-900"></p>
                                    <p id="file-size" class="text-xs text-gray-500"></p>
                                </div>
                                <button type="button" id="remove-file" class="text-sm text-red-600 hover:text-red-500 font-medium">
                                    Remove file
                                </button>
                            </div>
                        </div>
                        @error('featured_img')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('featured_img');
            const uploadArea = document.getElementById('upload-area');
            const uploadContent = document.getElementById('upload-content');
            const fileSelected = document.getElementById('file-selected');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const removeButton = document.getElementById('remove-file');

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    displayFile(file);
                }
            });

            removeButton.addEventListener('click', function() {
                fileInput.value = '';
                hideFile();
            });

            function displayFile(file) {
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                uploadContent.classList.add('hidden');
                fileSelected.classList.remove('hidden');
                uploadArea.classList.add('border-green-300', 'bg-green-50');
                uploadArea.classList.remove('border-gray-300');
            }

            function hideFile() {
                uploadContent.classList.remove('hidden');
                fileSelected.classList.add('hidden');
                uploadArea.classList.remove('border-green-300', 'bg-green-50');
                uploadArea.classList.add('border-gray-300');
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
</x-admin-layout>