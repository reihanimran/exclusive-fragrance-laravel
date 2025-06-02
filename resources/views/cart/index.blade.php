<x-app-layout>
    <x-slot name="title">Cart - Exclusive Fragrance</x-slot>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 bg-[#151E25]">
        <h1 class="text-white text-3xl font-bold mb-8">Your Cart</h1>
        
        <!-- Cart Items -->
        <div id="cartItems" class="grid grid-cols-1 gap-6">
            <!-- Cart items will be dynamically loaded here -->
        </div>

        <!-- Checkout or Continue Shopping -->
        <div class="mt-8 flex justify-start">
            <div id="checkoutButton" class="hidden">
                <a href="{{ route('cart.checkout') }}" class="bg-[#F5D57A] text-black px-6 py-2 rounded-md hover:bg-[#e0c060] transition-colors duration-300">
                    Proceed to Checkout
                </a>
            </div>
            <div id="continueShoppingButton" class="hidden">
                <a href="{{ route('shop.index') }}" class="bg-[#F5D57A] text-black px-6 py-2 rounded-md hover:bg-[#e0c060] transition-colors duration-300">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Fetch cart items from the server
        function fetchCartItems() {
            fetch('{{ route("cart.items") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const cartItemsContainer = document.getElementById('cartItems');
                    const checkoutButton = document.getElementById('checkoutButton');
                    const continueShoppingButton = document.getElementById('continueShoppingButton');

                    cartItemsContainer.innerHTML = '';

                    if (data.cart_items && data.cart_items.length > 0) {
                        // Display cart items
                        data.cart_items.forEach(item => {
                            const isPlusButtonDisabled = item.quantity >= item.stock_quantity;

                            cartItemsContainer.innerHTML += `
                                <div class="border border-[#F5D57A] rounded-lg p-4 flex flex-col md:flex-row items-center justify-between">
                                    <img src="${item.image_path}" 
                                         alt="${item.product_name}" 
                                         class="w-24 h-24 object-contain mb-4 md:mb-0">
                                    <div class="text-white text-center md:text-left">
                                        <h3 class="font-bold">${item.product_name}</h3>
                                        <p>Category: ${item.category_name}</p>
                                        <p>Fragrance: ${item.fragrance_type}</p>
                                        <p>Size: ${item.size}</p>
                                        <p>Price: Rs ${item.sale_price}</p>
                                        <p>Stock Available: ${item.stock_quantity}</p>
                                    </div>
                                    <div class="flex items-center mt-4 md:mt-0">
                                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})" 
                                                class="bg-[#F5D57A] text-black px-2 py-1 rounded-md">-</button>
                                        <span class="text-white mx-2">${item.quantity}</span>
                                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})" 
                                                class="bg-[#F5D57A] text-black px-2 py-1 rounded-md ${isPlusButtonDisabled ? 'opacity-50 cursor-not-allowed' : ''}" 
                                                ${isPlusButtonDisabled ? 'disabled' : ''}>+</button>
                                    </div>
                                    <button onclick="removeFromCart(${item.id})" 
                                            class="bg-red-500 text-white px-4 py-2 rounded-md mt-4 md:mt-0">Remove</button>
                                </div>
                            `;
                        });

                        // Show the "Proceed to Checkout" button
                        checkoutButton.classList.remove('hidden');
                        continueShoppingButton.classList.add('hidden');
                    } else {
                        // Display a message if the cart is empty
                        cartItemsContainer.innerHTML = `
                            <div class="text-center py-12 bg-[#1e293b] rounded-lg">
                                <i class="fas fa-shopping-cart text-5xl text-[#F5D57A] mb-4"></i>
                                <h3 class="text-xl font-semibold text-white mb-2">Your Cart is Empty</h3>
                                <p class="text-gray-400 mb-6">Add some products to your cart before checkout</p>
                            </div>
                        `;

                        // Show the "Continue Shopping" button
                        checkoutButton.classList.add('hidden');
                        continueShoppingButton.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error fetching cart items:', error));
        }

        // Update cart quantity
        function updateCartQuantity(itemId, quantity) {
            if (quantity < 0) return; // Prevent negative quantities
            
            fetch(`/cart/update/${itemId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: quantity }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Update failed');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        fetchCartItems(); // Refresh the cart items
                    } else {
                        alert(data.message || 'Failed to update quantity');
                    }
                })
                .catch(error => {
                    console.error('Error updating cart:', error);
                    alert('An error occurred while updating your cart');
                });
        }

        // Remove item from cart
        function removeFromCart(itemId) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) return;
            
            fetch(`/cart/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Remove failed');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        fetchCartItems();
                        updateCartCount(); // Refresh the cart items
                    } else {
                        alert(data.message || 'Failed to remove item');
                    }
                })
                .catch(error => {
                    console.error('Error removing item:', error);
                    alert('An error occurred while removing the item');
                });
        }

        // Fetch cart items on page load
        document.addEventListener('DOMContentLoaded', fetchCartItems);
    </script>
    @include('components.add-to-cart-script')
    @endpush
</x-app-layout>