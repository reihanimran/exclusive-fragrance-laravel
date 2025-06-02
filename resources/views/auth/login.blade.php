<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="uploads/images/ExclusiveFragranceLogo.png" alt="logo" class="w-60"/>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label class="text-white" for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full bg-[#151E25]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label class="text-white" for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full bg-[#151E25] text-white" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        {{-- Register link --}}
        <div class="mt-6 text-center">
            <p class="text-sm text-white">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-[#F5D57A] hover:text-yellow-400 font-medium">
                    Create one
                </a>
            </p>
        </div>
    </x-authentication-card>
</x-guest-layout>
