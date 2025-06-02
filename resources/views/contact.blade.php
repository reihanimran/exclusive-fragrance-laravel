<x-app-layout>
    @push('styles')
        <!-- ... existing styles ... -->
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

    <!-- ... existing sections ... -->

    <!-- Contact Form Section -->
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
                <form id="contactForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    <div class="md:col-span-2">
                        <h3 class="text-xl text-white mb-2 font-semibold">Send us a message</h3>
                        <div class="h-1 w-20 bg-[#F5D57A] mb-6"></div>
                    </div>
                    
                    <div>
                        <label for="name" class="block text-white mb-2">Full Name</label>
                        <input type="text" id="name" name="name" required 
                            class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:border-[#F5D57A]">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-white mb-2">Email Address</label>
                        <input type="email" id="email" name="email" required 
                            class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:border-[#F5D57A]">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-white mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                            class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:border-[#F5D57A]"
                            placeholder="(123) 456-7890">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-white mb-2">Subject</label>
                        <select id="subject" name="subject" required 
                            class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white focus:outline-none focus:border-[#F5D57A]">
                            <option value="" disabled selected>Select a subject</option>
                            <option value="product">Product Inquiry</option>
                            <option value="order">Order Support</option>
                            <option value="shipping">Shipping Information</option>
                            <option value="custom">Custom Fragrance</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="message" class="block text-white mb-2">Your Message</label>
                        <textarea id="message" name="message" rows="4" required 
                            class="w-full px-4 py-3 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:border-[#F5D57A]"></textarea>
                    </div>
                    
                    <div class="md:col-span-2 mt-4">
                        <button type="submit"
                            class="w-full md:w-auto px-8 py-3 bg-[#F5D57A] text-[#151E25] font-bold rounded-md hover:bg-[#d4b65e] transition-colors duration-300">
                            SEND MESSAGE
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

    @push('scripts')
        <script>
            document.getElementById('contactForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Form validation
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const subject = document.getElementById('subject').value;
                const message = document.getElementById('message').value;
                
                if (!name || !email || !subject || !message) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                // Prepare form data
                const formData = new FormData(this);
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = 'SENDING...';
                submitBtn.disabled = true;
                
                // Simulate form submission (in a real app, you'd use fetch to your backend)
                setTimeout(() => {
                    // Reset form
                    this.reset();
                    
                    // Show success message
                    submitBtn.innerHTML = 'MESSAGE SENT!';
                    submitBtn.classList.add('bg-green-500', 'hover:bg-green-600');
                    
                    // Reset button after delay
                    setTimeout(() => {
                        submitBtn.innerHTML = 'SEND MESSAGE';
                        submitBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
                        submitBtn.disabled = false;
                    }, 3000);
                }, 1500);
            });
        </script>
    @endpush
</x-app-layout>