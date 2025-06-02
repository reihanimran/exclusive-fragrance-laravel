<x-app-layout>
    <x-slot name="title">My Account</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#151E25] overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6 text-[#F5D57A] font-heading">Welcome back, {{ Auth::user()->name }}!</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Account Information Card -->
                        <div class="bg-[#1e293b] rounded-lg shadow-md p-6 border-l-4 border-[#F5D57A]">
                            <div class="flex items-start">
                                <div class="p-3 rounded-full bg-[#F5D57A] text-[#151E25] mr-4">
                                    <i class="fas fa-user-circle fa-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Account Information</h3>
                                    <div class="space-y-2">
                                        <div>
                                            <p class="text-sm text-gray-300">Email</p>
                                            <p class="text-white">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('profile.show') }}" class="text-[#F5D57A] hover:text-yellow-300 text-sm font-medium">
                                            Edit Account <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Shipping Information Card -->
                        <div class="bg-[#1e293b] rounded-lg shadow-md p-6 border-l-4 border-[#F5D57A]">
                            <div class="flex items-start">
                                <div class="p-3 rounded-full bg-[#F5D57A] text-[#151E25] mr-4">
                                    <i class="fas fa-truck fa-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Shipping Information</h3>
                                    @if(Auth::user()->shipping)
                                        <div class="space-y-2">
                                            <div>
                                                <p class="text-sm text-gray-300">Full Name</p>
                                                <p class="text-white">{{ Auth::user()->shipping->full_name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-300">Address</p>
                                                <p class="text-white">{{ Auth::user()->shipping->address }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-gray-300">No shipping information saved</p>
                                    @endif
                                    <div class="mt-4">
                                        <a href="{{ route('profile.shipping') }}" class="text-[#F5D57A] hover:text-yellow-300 text-sm font-medium">
                                            Manage Shipping <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order History Section -->
                    <div class="bg-[#1e293b] rounded-lg shadow-md p-6 mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-white">Recent Orders</h3>
                            @if(Auth::user()->orders && Auth::user()->orders->count() > 0)
                                <a href="{{ route('orders.index') }}" class="text-[#F5D57A] hover:text-yellow-300 text-sm font-medium">
                                    View All Orders <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            @endif
                        </div>
                        
                        @if(Auth::user()->orders && Auth::user()->orders->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-700">
                                    <thead class="bg-gray-800">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order ID</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Items</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-[#1e293b] divide-y divide-gray-700">
                                        @foreach(Auth::user()->orders->sortByDesc('created_at') as $order)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#F5D57A]">#{{ $order->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                    {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                    {{ $order->item_count }} items
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                    LKR {{ number_format($order->total_sale_amount, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @switch(strtolower($order->order_status))
                                                        @case('pending')
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                Pending
                                                            </span>
                                                            @break
                                                        @case('processing')
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                Processing
                                                            </span>
                                                            @break
                                                        @case('shipped')
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                                Shipped
                                                            </span>
                                                            @break
                                                        @case('delivered')
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                Delivered
                                                            </span>
                                                            @break
                                                        @case('cancelled')
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                Cancelled
                                                            </span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('orders.show', $order->id) }}" class="text-[#F5D57A] hover:text-yellow-300">
                                                        View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-box-open text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-400">You haven't placed any orders yet</p>
                                <a href="{{ route('products.index') }}" class="mt-3 inline-block px-4 py-2 bg-[#F5D57A] hover:bg-yellow-500 text-[#151E25] rounded-md font-medium">
                                    Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>