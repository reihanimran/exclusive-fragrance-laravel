<!-- resources/views/about.blade.php -->
<x-app-layout>
    <!-- Hero Banner -->
    <div class="relative w-full h-[40vh] flex items-center justify-center">
        <div class="absolute inset-0">
            <img src="{{ asset('uploads/banners/shop-bg.jpg') }}" alt="Shop Banner" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>
        <h1 class="relative text-white text-3xl md:text-5xl font-bold z-10">ABOUT US</h1>
    </div>

    <!-- Journey Section -->
    <section class="container mx-auto px-4 md:px-6 py-12 md:py-16">
        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
            <div class="order-2 md:order-1">
                <h2 class="text-3xl md:text-4xl text-white mb-4">A FRAGRANT JOURNEY<br/>
                    <span class="text-[#F5D57A]">BEYOND BUSINESS</span>
                </h2>
                <p class="text-gray-300">
                    At Exclusive Fragrance, we believe that a fragrance is more than just a scent – it's a connection, 
                    a memory, a story. Founded with the vision of creating a community where individuality is celebrated 
                    and cherished, we strive to craft perfumes that resonate deeply with your personality and emotions.
                </p>
            </div>
            <div class="rounded-lg overflow-hidden order-1 md:order-2">
                <img src="{{ asset('uploads/images/about-1.png') }}" alt="Fragrance crafting" class="w-full">
            </div>
        </div>
    </section>

    <!-- Craftsmanship Section -->
    <section class="py-12 md:py-16 bg-[#151E25]">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="order-2 md:order-1">
                    <img src="{{ asset('uploads/images/about-2.png') }}" alt="Natural ingredients" class="rounded-lg">
                </div>
                <div class="order-1 md:order-2">
                    <h2 class="text-3xl md:text-4xl text-white mb-4">OUR <span class="text-[#F5D57A]">CRAFTSMANSHIP</span></h2>
                    <p class="text-gray-300">
                        Every bottle we offer is a masterpiece, meticulously crafted with an unwavering commitment to detail. 
                        From sourcing the finest ingredients to working with world-renowned perfumers, we ensure each scent 
                        embodies luxury and authenticity.
                    </p>
                </div>
            </div>
        </div>
    </section>

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
                        Join the Exclusive Fragrance community and immerse yourself in a world where luxury meets personalization. Enjoy early access to our newest collections, exclusive offers designed just for
                        you, and personalized fragrance consultations to help you find the perfect scent. As a member, you’ll be part of a unique community that celebrates individuality and sophistication, offering an
                        experience that goes beyond just fragrance. <b>Join the Community</b> today and discover what makes us different. </p>
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
</x-app-layout>