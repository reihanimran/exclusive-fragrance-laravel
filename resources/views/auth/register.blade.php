<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                        autofocus autocomplete="name" />
                </div>

                <!-- Email -->
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autocomplete="username" />
                </div>

                <!-- Date of Birth -->
                <div>
                    <x-label for="date_of_birth" value="{{ __('Date of Birth') }}" />
                    <x-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth"
                        :value="old('date_of_birth')" required />
                </div>


                <!-- Contact Number -->
                <div>
                    <x-label for="contact_number" value="{{ __('Contact Number') }}" />
                    <x-input id="contact_number" class="block mt-1 w-full" type="tel" name="contact_number"
                        :value="old('contact_number')" required placeholder="(123) 456-7890" />
                </div>

                <!-- Profile Picture -->
                <div>
                    <x-label for="profile_photo_path" value="{{ __('Profile Picture') }}" />
                    <div class="flex items-center space-x-4 mt-1">
                        <div class="relative group">
                            <div
                                class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 flex items-center justify-center">
                                <svg id="placeholder-icon" class="w-8 h-8 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div
                                class="absolute inset-0 bg-black bg-opacity-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input id="profile_photo_path" name="profile_photo_path" type="file" class="hidden" accept="image/*"
                                onchange="previewProfilePhoto(event)" />
                            <button type="button" onclick="document.getElementById('profile_photo_path').click()"
                                class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                {{ __('Choose Photo') }}
                            </button>
                            <p class="mt-1 text-xs text-gray-500" id="file-name">
                                {{ __('PNG, JPG, or JPEG (max: 2MB)') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div>
                                    <x-label for="terms">
                                        <div class="flex items-center">
                                            <x-checkbox name="terms" id="terms" required />

                                            <div class="ms-2">
                                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                        'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' . __('Terms of Service') . '</a>',
                        'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' . __('Privacy Policy') . '</a>',
                    ]) !!}
                                            </div>
                                        </div>
                                    </x-label>
                                </div>
                @endif
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <script>
        function previewProfilePhoto(event) {
            const input = event.target;
            const fileNameDisplay = document.getElementById('file-name');
            const placeholderIcon = document.getElementById('placeholder-icon');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                // Display file name
                fileNameDisplay.textContent = file.name;

                // Preview image
                reader.onload = function (e) {
                    // Remove placeholder icon
                    if (placeholderIcon) {
                        placeholderIcon.parentNode.removeChild(placeholderIcon);
                    }

                    // Create or update preview image
                    let preview = input.parentElement.querySelector('img');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = 'w-16 h-16 rounded-xl object-cover';
                        input.parentElement.querySelector('.bg-gray-200').appendChild(preview);
                    }

                    preview.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        }
    </script>
</x-guest-layout>