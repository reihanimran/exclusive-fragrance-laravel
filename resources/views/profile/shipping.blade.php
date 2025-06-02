<x-app-layout>
    <x-slot name="title">Shipping Information</x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e293b] p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-[#F5D57A] mb-4">Manage Your Shipping Info</h2>

                <form method="POST" action="{{ route('profile.shipping.update') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-300">Full Name</label>
                        <input type="text" name="full_name" class="w-full p-2 rounded bg-gray-800 text-white" value="{{ old('full_name', $shipping->full_name ?? '') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300">Address</label>
                        <textarea name="address" class="w-full p-2 rounded bg-gray-800 text-white" required>{{ old('address', $shipping->address ?? '') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300">City</label>
                        <input type="text" name="city" class="w-full p-2 rounded bg-gray-800 text-white" value="{{ old('city', $shipping->city ?? '') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300">Postal Code</label>
                        <input type="text" name="postal_code" class="w-full p-2 rounded bg-gray-800 text-white" value="{{ old('postal_code', $shipping->postal_code ?? '') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300">Phone</label>
                        <input type="text" name="phone" class="w-full p-2 rounded bg-gray-800 text-white" value="{{ old('phone', $shipping->phone ?? '') }}">
                    </div>

                    <div class="text-right">
                        <button class="bg-[#F5D57A] text-[#151E25] px-4 py-2 rounded hover:bg-yellow-500">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
