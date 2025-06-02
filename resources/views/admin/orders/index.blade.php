<x-admin-layout>
    {{-- Success Message --}}
    @if (session('message'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            <span class="font-semibold">Success!</span> {{ session('message') }}
                        </p>
                    </div>
                </div>
                <button type="button" class="text-green-400 hover:text-green-600 focus:outline-none focus:text-green-600"
                    onclick="this.parentElement.parentElement.remove()">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Orders Management</h1>
            <p class="mt-2 text-sm text-gray-600">Manage and track all customer orders</p>
        </div>

        {{-- Main Card --}}
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            {{-- Card Header with Stats --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h2 class="text-xl font-semibold text-white">All Orders</h2>
                        <p class="text-blue-100 text-sm">Overview of order statistics</p>
                    </div>

                    {{-- Order Statistics --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center backdrop-blur-sm">
                            <div class="text-2xl font-bold text-white">{{ $orderStats['pending'] }}</div>
                            <div class="text-xs text-blue-100 font-medium">Pending</div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center backdrop-blur-sm">
                            <div class="text-2xl font-bold text-white">{{ $orderStats['completed'] }}</div>
                            <div class="text-xs text-blue-100 font-medium">Completed</div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center backdrop-blur-sm">
                            <div class="text-2xl font-bold text-white">{{ $orderStats['cancelled'] }}</div>
                            <div class="text-xs text-blue-100 font-medium">Cancelled</div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center backdrop-blur-sm">
                            <div class="text-2xl font-bold text-white">LKR
                                {{ number_format($orderStats['total_sales'], 2) }}</div>
                            <div class="text-xs text-blue-100 font-medium">Total Sales</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="ordersTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Items</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    <div class="flex-shrink-0 h-8 w-8">
                                                                        <div
                                                                            class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                                            <span class="text-sm font-medium text-gray-700">
                                                                                {{ substr($order->user->name ?? 'G', 0, 1) }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-3">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            {{ $order->user->name ?? 'Guest' }}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm text-gray-900">{{ $order->order_date->format('M d, Y') }}</div>
                                                                <div class="text-sm text-gray-500">{{ $order->order_date->format('H:i') }}</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-medium text-gray-900">{{ $order->items->sum('quantity') }}
                                                                </div>
                                                                <div class="text-xs text-gray-500">items</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-semibold text-gray-900">LKR
                                                                    {{ number_format($order->total_sale_amount + 500, 2) }}
</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                                    @if($order->order_status == 'Pending')
                                                                        bg-yellow-100 text-yellow-800
                                                                    @elseif($order->order_status == 'Processing')
                                                                        bg-blue-100 text-blue-800
                                                                    @elseif($order->order_status == 'Completed')
                                                                        bg-green-100 text-green-800
                                                                    @elseif($order->order_status == 'Cancelled')
                                                                        bg-red-100 text-red-800
                                                                    @endif
                                                                        ">
                                                                    {{ ucfirst($order->order_status) }}
                                                                </span>

                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                <div class="flex items-center space-x-3">
                                                                    {{-- View Button --}}
                                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                        </svg>
                                                                        View
                                                                    </a>

                                                                    {{-- Status Update Form --}}
                                                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                                                        method="POST" class="inline-block">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <select name="status"
                                                                            class="block w-full px-3 py-1.5 text-xs border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                                                            onchange="this.form.submit()">
                                                                            <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                            <option value="Processing" {{ $order->order_status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                                                            <option value="Completed" {{ $order->order_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                                            <option value="Cancelled" {{ $order->order_status == 'Cancelled' ? 'selected' : '' }}>Cancel</option>
                                                                        </select>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($orders->hasPages())
                    <div class="mt-6 flex justify-center">
                        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#ordersTable').DataTable({
                "paging": false,
                "info": false,
                "searching": true,
                "order": [[2, 'desc']],
                "dom": '<"flex justify-between items-center mb-4"<"flex-1"f><"flex-shrink-0 ml-4">>rt',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search orders..."
                }
            });

            // Style the search input
            $('.dataTables_filter input').addClass('block w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500');
            $('.dataTables_filter label').addClass('sr-only');
        });
    </script>
</x-admin-layout>