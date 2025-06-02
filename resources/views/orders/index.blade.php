<x-app-layout>
    <x-slot name="title">My Orders - Exclusive Fragrance</x-slot>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 bg-[#151E25]">
        <h1 class="text-white text-3xl font-bold mb-8">My Orders</h1>
        
        @if($orders->isEmpty())
            <div class="text-center py-12 bg-[#1e293b] rounded-lg">
                <i class="fas fa-box-open text-5xl text-[#F5D57A] mb-4"></i>
                <h3 class="text-xl font-semibold text-white mb-2">No Orders Found</h3>
                <p class="text-gray-400 mb-6">You haven't placed any orders yet</p>
                <a href="{{ route('shop.index') }}" class="bg-[#F5D57A] hover:bg-[#e0c060] text-[#151E25] py-2 px-6 rounded-md font-medium inline-block transition-colors">
                    Start Shopping
                </a>
            </div>
        @else
            <div class="bg-[#1e293b] rounded-lg overflow-hidden shadow">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-[#2d3748]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#F5D57A] uppercase tracking-wider">
                                Order #
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#F5D57A] uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#F5D57A] uppercase tracking-wider">
                                Items
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#F5D57A] uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#F5D57A] uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[#F5D57A] uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#1e293b] divide-y divide-gray-700">
                        @foreach($orders as $order)
                        <tr class="hover:bg-[#2d3748] transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $order->order_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $order->items->sum('quantity') }} items
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[#F5D57A]">
                                LKR {{ number_format($order->total_sale_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $order->order_status === 'Completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->order_status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->order_status === 'Processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $order->order_status === 'Cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('orders.show', $order->id) }}" class="text-[#F5D57A] hover:text-[#e0c060] mr-4">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                @if($order->order_status === 'Pending')
                                <button onclick="cancelOrder({{ $order->order_id }})" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times-circle mr-1"></i> Cancel
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
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