<!-- cart/checkout.blade.php -->
<x-app-layout>
    <x-slot name="title">Checkout - Exclusive Fragrance</x-slot>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 bg-[#151E25]">
        <!-- Breadcrumb Navigation -->
        <div class="mb-6">
            <nav class="text-sm text-gray-400">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ route('cart.index') }}" class="hover:text-[#F5D57A]">Cart</a>
                        <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path
                                d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <span class="text-[#F5D57A]">Checkout</span>
                    </li>
                </ol>
            </nav>
        </div>

        <h1 class="text-white text-3xl font-bold mb-8">Checkout</h1>

        <!-- Progress Indicator -->
        <div class="mb-10">
            <div class="flex justify-between relative">
                <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-700 -z-10"></div>
                <div class="absolute top-1/2 left-0 w-full h-1 bg-[#F5D57A] -z-10" style="width: 33%"></div>

                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-[#F5D57A] flex items-center justify-center mb-2">
                        <span class="text-[#151E25] font-bold">1</span>
                    </div>
                    <span class="text-white font-medium">Shipping</span>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center mb-2">
                        <span class="text-gray-400 font-bold">2</span>
                    </div>
                    <span class="text-gray-400">Payment</span>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center mb-2">
                        <span class="text-gray-400 font-bold">3</span>
                    </div>
                    <span class="text-gray-400">Confirmation</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Shipping Form -->
            <div class="lg:col-span-2">
                <div class="bg-[#1E293B] p-6 rounded-lg">
                    <h2 class="text-white text-2xl font-bold mb-6 border-b border-[#F5D57A] pb-3">Shipping Details</h2>
                    <form id="shipping-form">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-white text-sm font-bold mb-2" for="full_name">Full Name</label>
                                <input
                                    class="w-full bg-[#151E25] border border-gray-600 text-white rounded py-3 px-4 leading-tight focus:outline-none focus:border-[#F5D57A]"
                                    id="full_name" name="full_name" type="text" required
                                    value="{{ old('full_name', $shippingDetails->full_name ?? '') }}">
                            </div>
                            <div>
                                <label class="block text-white text-sm font-bold mb-2" for="phone">Phone</label>
                                <input
                                    class="w-full bg-[#151E25] border border-gray-600 text-white rounded py-3 px-4 leading-tight focus:outline-none focus:border-[#F5D57A]"
                                    id="phone" name="phone" type="text" required
                                    value="{{ old('phone', $shippingDetails->phone ?? '') }}">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-white text-sm font-bold mb-2" for="address">Address</label>
                            <textarea
                                class="w-full bg-[#151E25] border border-gray-600 text-white rounded py-3 px-4 leading-tight focus:outline-none focus:border-[#F5D57A]"
                                id="address" name="address" rows="3"
                                required>{{ old('address', $shippingDetails->address ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-white text-sm font-bold mb-2" for="city">City</label>
                                <input
                                    class="w-full bg-[#151E25] border border-gray-600 text-white rounded py-3 px-4 leading-tight focus:outline-none focus:border-[#F5D57A]"
                                    id="city" name="city" type="text" required
                                    value="{{ old('city', $shippingDetails->city ?? '') }}">
                            </div>
                            <div>
                                <label class="block text-white text-sm font-bold mb-2" for="postal_code">Postal
                                    Code</label>
                                <input
                                    class="w-full bg-[#151E25] border border-gray-600 text-white rounded py-3 px-4 leading-tight focus:outline-none focus:border-[#F5D57A]"
                                    id="postal_code" name="postal_code" type="text" required
                                    value="{{ old('postal_code', $shippingDetails->postal_code ?? '') }}">
                            </div>
                            <div>
                                <label class="block text-white text-sm font-bold mb-2" for="country">Country</label>
                                <select
                                    class="w-full bg-[#151E25] border border-gray-600 text-white rounded py-3 px-4 leading-tight focus:outline-none focus:border-[#F5D57A]"
                                    id="country" name="country" required>
                                    <option value="Sri Lanka" selected>Sri Lanka</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-white text-xl font-bold mb-4">Payment Method</h3>
                            <div class="space-y-4">
                                <label class="flex items-center bg-[#2d3748] p-4 rounded-lg cursor-pointer">
                                    <input type="radio" name="payment_method" value="credit_card"
                                        class="form-radio text-[#F5D57A]">
                                    <div class="ml-4">
                                        <span class="text-white font-medium">Credit Card</span>
                                        <div class="flex mt-3">
                                            <div class="w-10 h-6 bg-gray-200 rounded mr-2"></div>
                                            <div class="w-10 h-6 bg-gray-200 rounded mr-2"></div>
                                            <div class="w-10 h-6 bg-gray-200 rounded mr-2"></div>
                                            <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                        </div>
                                    </div>
                                </label>

                                <label class="flex items-center bg-[#2d3748] p-4 rounded-lg cursor-pointer">
                                    <input type="radio" name="payment_method" value="paypal"
                                        class="form-radio text-[#F5D57A]">
                                    <div class="ml-4 flex items-center">
                                        <div class="w-10 h-6 bg-blue-500 rounded mr-3 flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">PP</span>
                                        </div>
                                        <span class="text-white font-medium">PayPal</span>
                                    </div>
                                </label>

                                <label class="flex items-center bg-[#2d3748] p-4 rounded-lg cursor-pointer">
                                    <input type="radio" name="payment_method" value="cod"
                                        class="form-radio text-[#F5D57A]" checked>
                                    <div class="ml-4 flex items-center">
                                        <div
                                            class="w-10 h-6 bg-green-500 rounded mr-3 flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">COD</span>
                                        </div>
                                        <span class="text-white font-medium">Cash on Delivery</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-[#1E293B] p-6 rounded-lg sticky top-4">
                    <h2 class="text-white text-2xl font-bold mb-6 border-b border-[#F5D57A] pb-3">Order Summary</h2>

                    <div class="space-y-4 mb-6 max-h-96 overflow-y-auto pr-2">
                        @foreach($cart->items as $item)
                            <div class="border border-[#F5D57A] rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <img src="{{ $item->product->featuredImage ? asset($item->product->featuredImage->image_path) : asset('uploads/images/default-placeholder.png') }}"
                                            alt="{{ $item->product->product_name }}" class="w-20 h-20 object-contain">
                                    </div>
                                    <div class="flex-grow">
                                        <h3 class="font-bold text-white">{{ $item->product->product_name }}</h3>
                                        <p class="text-gray-400 text-sm">{{ $item->product->category->name }}</p>
                                        <div class="flex justify-between mt-2">
                                            <p class="text-white">LKR
                                                {{ number_format($item->product->sale_price ?? $item->product->original_price, 2) }}
                                                × {{ $item->quantity }}
                                            </p>
                                            <p class="text-[#F5D57A] font-semibold">
                                                LKR
                                                {{ number_format(($item->product->sale_price ?? $item->product->original_price) * $item->quantity, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-600 pt-4">
                        <div class="flex justify-between mb-3">
                            <span class="text-white">Subtotal</span>
                            <span class="text-white">LKR {{ number_format($cartTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-3">
                            <span class="text-white">Shipping</span>
                            <span class="text-white">LKR {{ number_format($shippingCost, 2) }}</span>
                        </div>
                        <div class="flex justify-between mt-4 pt-4 border-t border-gray-600">
                            <span class="text-xl font-bold text-[#F5D57A]">Total</span>
                            <span class="text-xl font-bold text-[#F5D57A]">LKR
                                {{ number_format($grandTotal, 2) }}</span>
                        </div>
                    </div>


                    <div class="mt-6">
                        <button id="place-order-btn"
                            class="w-full bg-[#F5D57A] text-[#151E25] font-bold py-3 rounded-lg focus:outline-none focus:shadow-outline text-lg hover:bg-[#e0c060] transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            Place Order
                        </button>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('shop.index') }}"
                            class="text-[#F5D57A] hover:underline inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const placeOrderButton = document.getElementById('place-order-btn');

                // Place order button handler
                placeOrderButton.addEventListener('click', function () {
                    const form = document.getElementById('shipping-form');
                    const formData = new FormData(form);

                    // Basic client-side validation
                    const requiredFields = ['full_name', 'phone', 'address', 'city', 'postal_code', 'country'];
                    for (const field of requiredFields) {
                        if (!formData.get(field)?.trim()) {
                            alert(`Please fill in your ${field.replace('_', ' ')}.`);
                            return;
                        }
                    }

                    // Validate payment method
                    const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
                    if (!paymentMethod) {
                        alert('Please select a payment method.');
                        return;
                    }

                    placeOrderButton.disabled = true;
                    const originalText = placeOrderButton.innerHTML;
                    placeOrderButton.innerHTML = `
                            <span class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-[#151E25]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing your order...
                            </span>
                        `;

                    // Submit the form
                    formData.append('payment_method', paymentMethod);

                    fetch('{{ route("cart.process-checkout") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                        .then(response => {
                            if (response.redirected) {
                                window.location.href = response.url;
                                return;
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data?.success) {
                                window.location.href = `/orders/${data.order_id}`;
                            } else {
                                alert(data.message || 'Failed to place order. Please try again.');
                                placeOrderButton.disabled = false;
                                placeOrderButton.innerHTML = originalText;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An unexpected error occurred. Please try again.');
                            placeOrderButton.disabled = false;
                            placeOrderButton.innerHTML = originalText;
                        });
                });
            });
        </script>
    @endpush

</x-app-layout>