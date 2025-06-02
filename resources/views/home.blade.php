<x-app-layout>
    <x-slot name="title">Exclusive Fragrance</x-slot>

    <!-- Hero Section -->
    <section class="relative w-full h-[85vh] flex items-center justify-center px-4 overflow-hidden">
        <div class="herosection absolute inset-0 z-0 flex items-center justify-center">
            <img src="{{ asset('uploads/images/hero-perfume.png') }}" alt="Luxury Fragrance"
                class="absolute top-24 w-[300px]">
            <div class="absolute inset-0 bg-black opacity-20"></div>
        </div>
        <h1 class="relative z-10 text-white text-4xl md:text-6xl text-center font-light leading-tight">
            "A Fragrance as Timeless as Your Love, Perfect for Your Wedding Day."
        </h1>
    </section>

    <!-- Gender Categories -->
    <section class="py-16 bg-[#151E25]">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach([['gender' => 'M', 'title' => 'SHOP MEN'], ['gender' => 'F', 'title' => 'SHOP WOMEN']] as $category)
                    <a href="{{ route('shop.index', ['gender' => $category['gender']]) }}"
                        class="group relative overflow-hidden rounded-lg transition-transform duration-300 hover:scale-[1.02]">
                        <img src="{{ asset('uploads/images/category-' . strtolower($category['title']) . '.png') }}"
                            alt="{{ $category['title'] }}" class="w-full h-96 object-cover">
                        <div class="absolute inset-0 bg-black/40 transition-opacity duration-300 group-hover:bg-black/30">
                        </div>
                        <h3
                            class="absolute bottom-0 left-0 right-0 p-6 text-center text-white text-2xl font-bold tracking-wider group-hover:text-[#F5D57A] transition-colors">
                            {{ $category['title'] }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Premium Collection -->
    <section class="py-16 bg-[#151E25]">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold mb-12">
                <span class="text-white">OUR </span>
                <span class="text-[#F5D57A]">PREMIUM</span>
                <span class="text-white"> COLLECTION</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($bestsellers as $product)
                                <article
                                    class="border border-[#F5D57A] rounded-lg p-6 transition-transform duration-300 hover:scale-105">
                                    <a href="{{ route('shop.show', $product->id) }}" class="block mb-6">
                                        <img src="{{ asset( 'storage/' . 
                        $product->featuredImage?->image_path
                    ) }}" alt="{{ $product->product_name }}" class="w-full h-64 object-contain">
                                    </a>
                                    <div class="text-center">
                                        <h3 class="text-white text-xl font-bold mb-4">{{ $product->product_name }}</h3>
                                        <p class="text-white text-lg mb-6">
                                            Rs {{ number_format($product->sale_price ?? $product->original_price, 2) }}
                                        </p>
                                        <button onclick="addToCart({{ $product->id }}, {{ $product->stock_quantity }})"
                                        class="w-full add-to-cart flex-1 bg-[#F5D57A] border-2 border-[#F5D57A] text-[#151E25] px-6 py-2 rounded-md hover:bg-opacity-90 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                        @if($product->stock_quantity <= 0) disabled @endif>
                                        @if($product->stock_quantity <= 0)
                                            Out of Stock
                                        @else
                                                Add to Cart
                                        @endif
                                </button>
                                    </div>
                                </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-16 bg-[#151E25]">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold mb-12">
                <span class="text-white">HANDPICKED SCENTS FOR</span><br>
                <span class="text-[#F5D57A]">EVERY OCCASION</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 auto-rows-[300px]">
                @foreach($featuredCategories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->category_id]) }}"
                        class="relative group overflow-hidden rounded-2xl col-span-{{ $loop->first ? '2' : '1' }}">
                        <img src="{{ asset('storage/' . $category->featured_img)  }}" alt="{{ $category->category_name }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-opacity"></div>
                        <h3 class="absolute bottom-0 left-0 right-0 p-6 text-white text-2xl font-bold text-center">
                            {{ $category->category_name }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 bg-[#151E25]">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <h2 class="text-4xl font-bold mb-8">
                        <span class="text-white">MORE THAN A FRAGRANCE</span><br>
                        <span class="text-[#F5D57A]">A CONNECTION</span>
                    </h2>
                    <p class="text-white text-lg leading-relaxed mb-8">
                        At Exclusive Fragrance, we believe a scent is more than just an accessory -
                        it's a story, an identity, and a memory waiting to be created. Our mission is
                        to bring together a community that celebrates individuality, sophistication,
                        and the art of fine perfumery.
                    </p>
                    <a href="{{ route('about') }}"
                        class="inline-block border-2 border-[#F5D57A] text-[#F5D57A] px-6 py-2 hover:bg-[#F5D57A] hover:text-black transition-colors">
                        Learn More About Us
                    </a>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset('uploads/images/Home-aboutusimg.png') }}" alt="About Exclusive Fragrance"
                        class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <!-- Call to Action Section -->
    <div>
        <div class="relative container mx-auto px-12 py-16">
            <!-- Heading -->
            <div class="text-left mb-12">
                <h2 class="text-2xl md:text-4xl font-bold mb-2">
                    <div class="text-white">BE PART OF</div>
                    <div class="text-[#F5D57A]">SOMETHING SPECIAL</div>
                </h2>
            </div>

            <!-- Description -->
            <div class="cto rounded-lg p-6 md:p-24">
                <div class="mx-auto text-center mb-12">
                    <p class="text-white leading-relaxed mb-8">
                        Join the Exclusive Fragrance community and immerse yourself in a world where luxury meets
                        personalization. Enjoy early access to our newest collections, exclusive offers designed just
                        for
                        you, and personalized fragrance consultations to help you find the perfect scent. As a member,
                        you’ll be part of a unique community that celebrates individuality and sophistication, offering
                        an
                        experience that goes beyond just fragrance. <b>Join the Community</b> today and discover what
                        makes us different. </p>
                </div>

                <!-- Form Section -->
                <div class="max-w-md mx-auto">
                    <form class="flex justify-between border-2 border-[#F5D57A] rounded-md">
                        <input type="email" placeholder="Your email address"
                            class="pl-2 md:px-4 py-3 bg-transparent text-white placeholder-white placeholder-opacity-75 focus:outline-none focus:border-[#F5D57A]" />
                        <button type="submit"
                            class="px-2 md:px-8 py-3 bg-[#F5D57A] bg-opacity-40 text-white font-semibold hover:bg-opacity-90 hover:text-[#151E25] transition-colors duration-300">
                            SIGN UP
                        </button>
                    </form>

                    <!-- Additional Text -->
                    <p class="text-white text-center mt-8 text-sm italic">
                        "This is more than just about fragrances, it's about belonging to a community that values
                        individuality and luxury."
                    </p>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        @include('components.add-to-cart-script')
    @endpush
</x-app-layout>