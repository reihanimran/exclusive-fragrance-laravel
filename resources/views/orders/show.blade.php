<x-app-layout>
    <x-slot name="title">Order #{{ $order->id }} - Exclusive Fragrance</x-slot>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 bg-[#151E25]">
        <!-- Order Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-white text-3xl font-bold">Order #{{ $order->id }}</h1>
                <p class="text-gray-400">Placed on {{ $order->order_date->format('F j, Y \a\t g:i A') }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                @php
                    $statusClasses = match (strtolower($order->order_status)) {
                        'completed' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'processing' => 'bg-blue-100 text-blue-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp

                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses }}">
                    {{ ucfirst($order->order_status) }}
                </span>

                @if($order->order_status === 'Pending')
                    <button onclick="cancelOrder({{ $order->id }})" class="ml-4 text-red-500 hover:text-red-700 text-sm">
                        <i class="fas fa-times-circle mr-1"></i> Cancel Order
                    </button>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2">
                <!-- Order Items -->
                <div class="bg-[#1E293B] rounded-lg p-6 mb-8">
                    <h2 class="text-white text-xl font-bold mb-6 pb-2 border-b border-[#F5D57A]">Order Items</h2>
                    <div class="space-y-6">
                        @foreach($order->items as $item)
                            <div class="flex flex-col md:flex-row items-start border-b border-gray-700 pb-6">
                                <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                                    <img src="{{ $item->product->featuredImage ? asset($item->product->featuredImage->image_path) : asset('uploads/images/default-placeholder.png') }}"
                                        alt="{{ $item->product->product_name }}" class="w-24 h-24 object-contain">
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-white font-bold text-lg">{{ $item->product->product_name }}</h3>
                                    <p class="text-gray-400">{{ $item->product->category->name }}</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <p class="text-gray-400 text-sm">Fragrance Type</p>
                                            <p class="text-white">{{ $item->product->fragrance_type }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm">Size</p>
                                            <p class="text-white">{{ $item->product->size }}ml</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm">Unit Price</p>
                                            <p class="text-white">LKR {{ number_format($item->sale_item_price, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-sm">Quantity</p>
                                            <p class="text-white">{{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 md:ml-auto">
                                    <p class="text-lg font-bold text-[#F5D57A]">LKR
                                        {{ number_format($item->sale_item_price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-[#1E293B] rounded-lg p-6">
                    <h2 class="text-white text-xl font-bold mb-6 pb-2 border-b border-[#F5D57A]">Order Summary</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-white font-bold mb-3">Payment Information</h3>
                            <div class="bg-[#2d3748] rounded-lg p-4">
                                <p class="text-gray-400">Payment Method</p>
                                <p class="text-white font-medium">
                                    @if($order->payment_method === 'cod')
                                        Cash on Delivery
                                    @elseif($order->payment_method === 'credit_card')
                                        Credit Card
                                    @elseif($order->payment_method === 'paypal')
                                        PayPal
                                    @else
                                        {{ ucfirst($order->payment_method) }}
                                    @endif
                                </p>
                                <p class="text-gray-400 mt-3">Payment Status</p>
                                <p class="text-white font-medium">
                                    @if($order->order_status === 'Completed')
                                        Paid
                                    @elseif($order->order_status === 'Cancelled')
                                        Refunded
                                    @else
                                        Pending
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-white font-bold mb-3">Order Total</h3>
                            <div class="bg-[#2d3748] rounded-lg p-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-400">Subtotal</span>
                                    <span class="text-white">LKR
                                        {{ number_format($order->total_sale_amount - 500, 2) }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-400">Shipping</span>
                                    <span class="text-white">LKR 500.00</span>
                                </div>
                                <div class="flex justify-between mt-3 pt-3 border-t border-gray-600">
                                    <span class="text-lg font-bold text-[#F5D57A]">Total</span>
                                    <span class="text-lg font-bold text-[#F5D57A]">LKR
                                        {{ number_format($order->total_sale_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="lg:col-span-1">
                <div class="bg-[#1E293B] rounded-lg p-6 sticky top-4">
                    <h2 class="text-white text-xl font-bold mb-6 pb-2 border-b border-[#F5D57A]">Shipping Information
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <p class="text-gray-400 text-sm">Full Name</p>
                            <p class="text-white font-medium">{{ $order->shipping->full_name }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-sm">Phone</p>
                            <p class="text-white font-medium">{{ $order->shipping->phone }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-sm">Address</p>
                            <p class="text-white font-medium">{{ $order->shipping->address }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-sm">City</p>
                            <p class="text-white font-medium">{{ $order->shipping->city }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 text-sm">Postal Code</p>
                            <p class="text-white font-medium">{{ $order->shipping->postal_code }}</p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-gray-700">
                            <p class="text-gray-400 text-sm">Shipping Status</p>
                            <p class="text-white font-medium">
                                @if($order->order_status === 'completed')
                                    Delivered on {{ $order->updated_at->format('M d, Y') }}
                                @elseif($order->order_status === 'cancelled')
                                    Cancelled
                                @else
                                    Processing
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button onclick="window.print()"
                            class="w-full bg-[#2d3748] text-white py-2 px-4 rounded-md hover:bg-[#3c485c] transition-colors mb-3">
                            <i class="fas fa-print mr-2"></i> Print Invoice
                        </button>
                        <a href="{{ route('orders.invoice', $order->id) }}"
                            class="block w-full bg-[#F5D57A] text-[#151E25] text-center py-2 px-4 rounded-md hover:bg-[#e0c060] transition-colors">
                            <i class="fas fa-download mr-2"></i> Download Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function cancelOrder(orderId) {
                if (!confirm('Are you sure you want to cancel this order?')) return;

                fetch(`/orders/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Order has been cancelled successfully.');
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to cancel order.');
                        }
                    })
                    .catch(error => {
                        console.error('Error cancelling order:', error);
                        alert('An error occurred while cancelling the order.');
                    });
            }
        </script>
    @endpush
</x-app-layout>