<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
                <p class="mt-2 text-sm text-gray-600">View and manage order information</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Orders
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Order Items Section --}}
            <div class="lg:col-span-2">
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    {{-- Order Header --}}
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-white">Order #{{ $order->id }}</h2>
                                <p class="text-blue-100 text-sm">{{ $order->order_date->format('M d, Y H:i') }}</p>
                            </div>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                @if($order->order_status == 'completed') bg-green-100 text-green-800
                                @elseif($order->order_status == 'cancelled') bg-red-100 text-red-800
                                @elseif($order->order_status == 'processing') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Order Items Table --}}
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if($item->product->featuredImage)
                                                        <div class="flex-shrink-0 h-12 w-12">
                                                            <img class="h-12 w-12 rounded-lg object-cover shadow-sm"
                                                                src="{{ asset($item->product->featuredImage->image_path) }}"
                                                                alt="{{ $item->product->name }}">
                                                        </div>
                                                    @else
                                                        <div
                                                            class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->product->product_name }}</div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $item->product->category->category_name ?? 'Uncategorized' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">LKR
                                                    {{ number_format($item->sale_item_price, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $item->quantity }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">LKR
                                                    {{ number_format($item->sale_item_price * $item->quantity, 2) }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Order Totals --}}
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-medium text-gray-600">Subtotal:</span>
                                    <span class="font-semibold text-gray-900">LKR
                                        {{ number_format($order->total_sale_amount, 2) }}</span>
                                </div>
                                @if($order->shipping)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-medium text-gray-600">Shipping:</span>
                                        <span class="font-semibold text-gray-900">LKR {{ number_format(500, 2) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between items-center text-lg border-t border-gray-200 pt-3">
                                    <span class="font-bold text-gray-900">Total:</span>
                                    <span class="font-bold text-blue-600">LKR
                                        {{ number_format($order->total_sale_amount + 500, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Customer Details Card --}}
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Customer Details</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ substr($order->user->name ?? 'G', 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                                <div class="text-sm text-gray-500">{{ $order->user->email ?? 'No email provided' }}
                                </div>
                            </div>
                        </div>

                        @if($order->shipping)
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Shipping Address
                                </h4>
                                <div class="text-sm text-gray-600 space-y-1">
                                    <p>{{ $order->shipping->address }}</p>
                                    @if($order->shipping->address_line2)
                                        <p>{{ $order->shipping->address_line2 }}</p>
                                    @endif
                                    <p>{{ $order->shipping->city }}, {{ $order->shipping->postal_code }}</p>
                                    <p>{{ $order->shipping->country }}</p>
                                    <div class="flex items-center mt-2 pt-2 border-t border-gray-100">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="font-medium">{{ $order->shipping->phone }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Order Actions Card --}}
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Order Actions</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        {{-- Status Update Form --}}
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST"
                            class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update
                                    Status</label>
                                <select name="status" id="status"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="Processing" {{ $order->order_status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="Completed" {{ $order->order_status == 'Completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="Cancelled" {{ $order->order_status == 'Cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Update Status
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>