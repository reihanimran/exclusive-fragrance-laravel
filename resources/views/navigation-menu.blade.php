<!-- resources/views/layouts/partials/header.blade.php -->
<nav x-data="{ open: false, mobileOpen: false }" class="bg-[#151E25] py-4">
    <!-- Primary Navigation Menu -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('uploads/images/ExclusiveFragranceLogo.png') }}" alt="Exclusive Fragrance Logo"
                        class="h-16 md:h-24">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-20 mr-4">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')"
                    class="text-white hover:text-[#F5D57A] border-b-2 border-transparent hover:border-[#F5D57A]">
                    {{ __('Home') }}
                </x-nav-link>
                <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')"
                    class="text-white hover:text-[#F5D57A] border-b-2 border-transparent hover:border-[#F5D57A]">
                    {{ __('About Us') }}
                </x-nav-link>
                <x-nav-link href="{{ route('shop.index') }}" :active="request()->routeIs('shop.*')"
                    class="text-white hover:text-[#F5D57A] border-b-2 border-transparent hover:border-[#F5D57A]">
                    {{ __('Shop') }}
                </x-nav-link>
                <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')"
                    class="text-white hover:text-[#F5D57A] border-b-2 border-transparent hover:border-[#F5D57A]">
                    {{ __('Contact') }}
                </x-nav-link>

                <!-- User & Cart Icons -->
                <div class="flex items-center space-x-6">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover border border-[#F5D57A]"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <i class="fa-regular fa-user fa-lg text-white hover:text-[#F5D57A]"></i>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-[#F5D57A]">
                            <i class="fa-regular fa-user fa-lg"></i>
                        </a>
                    @endauth

                    <a href="{{ route('cart.index') }}" class="relative text-white hover:text-[#F5D57A]">
                        <i class="fa-solid fa-cart-shopping fa-lg"></i>
                        @auth
                        <span
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs cart-count">
                            {{ auth()->user()->activeCartItems()->count() }}
                        </span>
                        @endauth
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileOpen = !mobileOpen" class="text-[#151E25]">
                    <img src="{{ asset('uploads/icons/menu.png') }}" alt="Menu" class="w-8 h-8">
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-show="mobileOpen" @click.away="mobileOpen = false"
        class="fixed z-20 top-0 left-0 w-full h-screen bg-white md:hidden transition-transform duration-500 ease-in-out">
        <div class="container mx-auto px-4 pt-16">
            <!-- Close Button -->
            <button @click="mobileOpen = false" class="absolute top-8 right-8">
                <img src="{{ asset('uploads/icons/close.png') }}" alt="Close" class="w-8 h-8">
            </button>

            <!-- Mobile Links -->
            <div class="space-y-6">
                <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">
                    {{ __('About Us') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('shop.index') }}" :active="request()->routeIs('shop.*')">
                    {{ __('Shop') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">
                    {{ __('Contact') }}
                </x-responsive-nav-link>

                <!-- Mobile Auth Links -->
                <div class="pt-4 border-t border-gray-200">
                    @auth
                        <div class="flex items-center justify-center space-x-6">
                            <x-responsive-nav-link href="{{ route('profile.show') }}" class="!px-0">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <img class="h-8 w-8 rounded-full object-cover border border-[#F5D57A]"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                @else
                                    <i class="fa-regular fa-user fa-lg"></i>
                                @endif
                            </x-responsive-nav-link>

                            <x-responsive-nav-link href="{{ route('cart.index') }}" class="!px-0 relative">
                                <i class="fa-solid fa-cart-shopping fa-lg"></i>
                                @auth
                                    <span
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs cart-count">
                                        {{ auth()->user()->activeCartItems()->count()}}
                                    </span>
                                @endauth
                            </x-responsive-nav-link>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <x-responsive-nav-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    @else
                        <div class="flex flex-col space-y-4">
                            <x-responsive-nav-link href="{{ route('login') }}">
                                {{ __('Login') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('register') }}">
                                {{ __('Register') }}
                            </x-responsive-nav-link>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
