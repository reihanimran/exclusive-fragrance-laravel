<footer class="text-gray-200 py-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-2xl font-bold mb-4 tracking-wide text-[#F5D57A]">Exclusive Fragrance</h3>
                <p class="text-gray-400">Premium perfumes curated for refined taste. Step into elegance and aroma.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Home</a></li>
                    <li><a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-white">Shop</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Customer Care</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Shipping Policy</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Return Policy</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Terms & Conditions</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Contact</h3>
                <p class="text-gray-400 mb-2">No. 27, Nugegoda, Colombo, Sri Lanka</p>
                <p class="text-gray-400 mb-2">Email: hello@exclusivefragrance.lk</p>
                <p class="text-gray-400 mb-4">Phone: +94 77 123 4567</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-10 pt-8 border-t border-gray-700 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} Exclusive Fragrance. All rights reserved.</p>
        </div>
    </div>
</footer>
