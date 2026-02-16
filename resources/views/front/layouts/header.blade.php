<header class="sticky top-0 z-50 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border-b border-gray-100 dark:border-gray-700 shadow-sm transition-colors duration-300">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <img src="{{ asset('admin-assets/img/AdminLogo.png') }}" alt="Logo" class="w-12 h-12 object-contain transition-transform group-hover:scale-110 duration-300" style="opacity: .9">
                    </div>
                    <span class="text-2xl font-black bg-gradient-to-r from-primary-600 via-primary-500 to-accent-500 bg-clip-text text-transparent tracking-tight">
                        ElectroStore
                    </span>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-1">
                @php
                    $navLinks = [
                        ['route' => 'home', 'label' => __('messages.home')],
                        ['route' => 'shop.index', 'label' => __('messages.shop')],
                        ['route' => 'category.index', 'label' => __('messages.categories')],
                        ['route' => 'order.index', 'label' => __('messages.my_orders'), 'auth' => true],
                        ['route' => 'about.index', 'label' => __('messages.about')],
                        ['route' => 'contact.index', 'label' => __('messages.contact')],
                    ];
                @endphp
                @foreach($navLinks as $link)
                    @if($link['route'] === 'order.index' && !auth()->check())
                        @continue   
                    @endif
                     <a href="{{ route($link['route']) }}"
                       class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300
                              {{ request()->routeIs($link['route'])
                                  ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400'
                                  : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400' }}">
                        {{ $link['label'] }} 
                    </a>
                @endforeach
            </div>

            <div class="flex items-center space-x-2">

                {{-- Language Switcher --}}
                {{-- <div class="relative group">
                    <button class="flex items-center text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium text-sm transition-colors">
                        @if(App::getLocale() == 'ar')
                            <span class="mr-1">🇺🇸</span> English
                        @else
                            <span class="mr-1">🇸🇦</span> العربية
                        @endif
                    </button>
                    <div class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 hidden group-hover:block z-50">
                        <a href="{{ route('locale.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-600">
                            🇺🇸 English
                        </a>
                        <a href="{{ route('locale.switch', 'ar') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-600 text-right">
                            🇸🇦 العربية
                        </a>
                    </div>
                </div> --}}

                <form action="{{ route('shop.search') }}" method="GET" class="hidden lg:block relative group">
                    <input type="text" name="q" placeholder="{{ __('messages.search_placeholder') }}"
                           class="w-48 pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-100 border-none rounded-2xl text-sm focus:w-64 focus:ring-2 focus:ring-primary-100 dark:focus:ring-primary-800 transition-all duration-500 outline-none">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>

                {{-- Dark Mode Toggle --}}
                <button onclick="toggleTheme()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Toggle Dark Mode">
                    {{-- Sun Icon (show in dark mode) --}}
                    <svg class="w-6 h-6 text-yellow-400 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{-- Moon Icon (show in light mode) --}}
                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-400 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                {{-- wishlist + cart --}}
                <div class="flex items-center border-l border-gray-100 dark:border-gray-700 ml-2 pl-2 gap-1">

                    {{-- wishlist --}}
                    <a href="{{ route('wishlist.index') }}"
                       class="relative inline-flex items-center justify-center p-2.5 rounded-xl
                              text-gray-600 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-500
                              transition-all duration-300">

                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>

                        <span
                            class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center
                                   rounded-full bg-red-500 text-[10px] font-bold text-white
                                   ring-2 ring-white dark:ring-gray-800">
                            {{ auth()->check() ? auth()->user()->wishlistItems()->count() : 0 }}
                        </span>
                    </a>

                    {{-- cart --}}
                    <a href="{{ route('front.cards.index') }}"
                       class="relative inline-flex items-center justify-center p-2.5 rounded-xl
                              text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600
                              transition-all duration-300">

                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        <span
                            class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center
                                   rounded-full bg-accent-600 text-[10px] font-bold text-white
                                   ring-2 ring-white dark:ring-gray-800">
                            {{ session()->has('cart') ? count(session()->get('cart')) : 0 }}
                        </span>
                    </a>

                </div>


               <div class="border-l border-gray-200 dark:border-gray-700 pl-4">
                    @auth
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none group">
                                <div class="w-10 h-10 rounded-full border-2 border-gray-100 dark:border-gray-600 group-hover:border-primary-500 transition-all overflow-hidden">
                                    <img src="{{ asset('admin-assets/img/avatar5.png') }}" alt="User Avatar" class="w-full h-full object-cover">
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-none">{{ __('messages.welcome') }},</p>
                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-200 leading-tight">{{ Auth::user()->name }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-primary-600 transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 py-2 z-50">

                                <div class="px-4 py-2 border-b border-gray-50 dark:border-gray-700 mb-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                @php $role = (int) (auth()->user()->role_id ?? 3); @endphp
                                @if(in_array($role, [1, 2]))
                                    <a href="{{ url('/dashboard') }}"
                                       class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-600 transition-colors">
                                        <i class="fas fa-chart-line w-5 mr-2"></i> {{ __('messages.dashboard') }}
                                    </a>

                                    @if($role === 1)
                                        <a href="{{ url('/super-admins') }}"
                                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-600 transition-colors">
                                            <i class="fas fa-user-shield w-5 mr-2"></i> {{ __('messages.management') }}
                                        </a>
                                    @endif
                                @endif

                                <a href="{{ route('password.change') }}"
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-600 transition-colors">
                                    <i class="fas fa-key w-5 mr-2"></i> {{ __('messages.change_password') }}
                                </a>

                                <div class="border-t border-gray-50 dark:border-gray-700 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <i class="fas fa-sign-out-alt w-5 mr-2"></i> {{ __('messages.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">{{ __('messages.login') }}</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-full hover:bg-primary-700 transition-colors">
                                    {{ __('messages.register') }}
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>


                <div class="md:hidden">
                    <button class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round"/></svg></button>
                </div>
            </div>
        </div>
    </nav>
</header>