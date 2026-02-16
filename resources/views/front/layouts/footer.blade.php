<!-- Footer -->
<footer class="bg-gray-900 dark:bg-gray-950 text-white mt-20 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-accent-600 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('admin-assets/img/AdminLogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    </div>
                    <span class="text-xl font-bold">ElectroStore</span>
                </div>
                <p class="text-gray-400">
                    {{ __('messages.description') }}
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">{{ __('messages.quick_links') }}</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">{{ __('messages.home') }}</a></li>
                    <li><a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-white transition-colors">{{ __('messages.shop') }}</a></li>
                    <li><a href="{{ route('category.index') }}" class="text-gray-400 hover:text-white transition-colors">{{ __('messages.categories') }}</a></li>
                @auth
                    <li>
                         <a href="{{ route('order.index') }}" class="text-gray-400 hover:text-white transition-colors">
                                  {{ __('messages.my_orders') }}
                         </a>
                    </li>
                @endauth                   
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-4">{{ __('messages.contact') }}</h3>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>TeamCoder@gmail.com</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>+967 776893799</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 dark:border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} ElectroStore. {{ __('messages.rights_reserved') }} <br>{{ __('messages.by') }} <span class="text-primary-600">Team Coder.</span></p>
        </div>
    </div>
</footer>