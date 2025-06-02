@once
    @push('scripts')
        <script>
            function addToCart(productId, quantity = 1) {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('quantity', quantity);

                fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(async response => {
                        if (response.status === 401) {
                            alert('Please login to add items to your cart');
                            window.location.href = '/login';
                            return;
                        }

                        const data = await response.json();

                        if (data.success) {
                            alert('Product added to cart');
                            updateCartCount();
                        } else if (data.redirect) {
                            alert(data.message);
                            window.location.href = data.redirect;
                        } else {
                            alert(data.message || 'Failed to add to cart');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to add to cart');
                    });
            }

                function updateCartCount() {
                    fetch('/cart/count', {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update all elements with class 'cart-count'
                        const cartCountElements = document.querySelectorAll('.cart-count');
                        cartCountElements.forEach(element => {
                            console.log(data.count);
                            element.textContent = data.count;
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching cart count:', error);
                    });
                }

        </script>
    @endpush
@endonce