@push('styles')
<style>
    .contact-form {
        background-image: url("{{ asset('uploads/images/contact-bg.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }
    
    .contact-form::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(21, 30, 37, 0.85);
        z-index: 0;
    }
    
    .contact-form > * {
        position: relative;
        z-index: 1;
    }
</style>
@endpush

<section class="contact-form py-16">
    <div class="container mx-auto px-4 md:px-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                <span class="text-[#F5D57A]">CONTACT</span> US
            </h2>
            <p class="text-gray-300 max-w-2xl mx-auto">
                Have questions about our fragrances or need assistance? Our team is ready to help you find your perfect scent.
            </p>
        </div>

        <div class="max-w-4xl mx-auto bg-[#1e293b] bg-opacity-80 rounded-xl p-6 md:p-10">
            @if($showSuccessMessage)
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-cloak
                x-init="setTimeout(() => { show = false; $wire.hideSuccessMessage(); }, 5000)" 
                class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
            >
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">Thank you for your message!</span>
                </div>
                <p class="mt-1 text-sm">We'll get back to you within 24 hours.</p>
                <button @click="show = false; $wire.hideSuccessMessage()" class="absolute top-0 right-0 p-4">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            @endif

            @error('form')
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ $message }}
            </div>
            @enderror

            <form wire:submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <h3 class="text-xl text-white mb-2 font-semibold">Send us a message</h3>
                    <div class="h-1 w-20 bg-[#F5D57A] mb-6"></div>
                </div>
                
                <div>
                    <label for="name" class="block text-white mb-2">Full Name</label>
                    <input type="text" id="name" wire:model="name" 
                        class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:border-[#F5D57A]">
                    @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-white mb-2">Email Address</label>
                    <input type="email" id="email" wire:model="email" 
                        class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:border-[#F5D57A]">
                    @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="phone" class="block text-white mb-2">Phone Number</label>
                    <input type="tel" id="phone" wire:model="phone" 
                        class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:border-[#F5D57A]"
                        placeholder="(123) 456-7890">
                </div>
                
                <div>
                    <label for="subject" class="block text-white mb-2">Subject</label>
                    <select id="subject" wire:model="subject" 
                        class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white focus:outline-none focus:border-[#F5D57A]">
                        <option value="" disabled>Select a subject</option>
                        <option value="Product Inquiry">Product Inquiry</option>
                        <option value="Order Support">Order Support</option>
                        <option value="Shipping Information">Shipping Information</option>
                        <option value="Custom Fragrance">Custom Fragrance</option>
                        <option value="Other">Other</option>
                    </select>
                    @error('subject') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="message" class="block text-white mb-2">Your Message</label>
                    <textarea id="message" wire:model="message" rows="4" 
                        class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:border-[#F5D57A]"></textarea>
                    @error('message') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="md:col-span-2 mt-4">
                   <button type="submit" wire:loading.attr="disabled"
    class="w-full md:w-auto px-8 py-3 font-bold rounded-md bg-[#F5D57A] text-[#151E25] hover:bg-[#d4b65e] transition-colors duration-300 disabled:bg-gray-500 disabled:text-white disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="submitForm">
                            SEND MESSAGE
                        </span>
                        <span wire:loading wire:target="submitForm">
                            <i class="fas fa-spinner fa-spin mr-2"></i> SENDING...
                        </span>
                    </button>
                </div>
                
                <div class="md:col-span-2 mt-6 flex items-center">
                    <div class="mr-4 text-[#F5D57A]">
                        <i class="fas fa-phone-alt text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white text-lg font-medium">+94 77 123 4567</p>
                        <p class="text-gray-400">Monday-Friday, 9am-5pm</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
