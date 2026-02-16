@extends('front.layouts.app')

@section('title', 'About Us | Laravel E-com')

@section('content')
<main class="max-w-[1200px] mx-auto pb-20">

    <!-- Breadcrumbs -->
    <div class="px-6 py-6 flex items-center gap-2 text-sm">
        <a class="text-[#617c89] dark:text-gray-400 font-medium hover:text-primary transition-colors"
           href="{{ url('/') }}">Home</a>
        <span class="text-[#617c89] dark:text-gray-600">/</span>
        <span class="text-[#111618] dark:text-white font-medium">About Us</span>
    </div>

    <!-- Hero Section -->
    <section class="px-6 mb-16">
        <div class="relative overflow-hidden rounded-xl">
            <div class="min-h-[420px] flex flex-col items-center justify-center p-8 text-center bg-cover bg-center"
                 style='background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), url("{{ asset('admin-assets/img/...png') }}");'>
                <div class="max-w-[720px] space-y-6">
                    <h1 class="text-white text-4xl md:text-6xl font-black leading-tight tracking-tight">
                        Who We Are
                    </h1>

                    <p class="text-white/90 text-lg md:text-xl font-normal leading-relaxed">
                        Redefining the modern shopping experience through quality and innovation. Founded on the principles of excellence and customer-centric design since 2012.
                    </p>

                    <div class="pt-4">
                        {{-- لا أفترض اسم Route للمنتجات عندك، لذلك خليتها رابط مباشر للـ /products --}}
                        <a href="{{ url('/shop') }}"
                           class="inline-block bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-lg font-bold text-base transition-all shadow-lg shadow-primary/20">
                            View Our Collection
                        </a>
                    </div>
                </div>  
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="px-6 mb-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-6">
                <div class="inline-block px-3 py-1 bg-primary/10 text-primary text-xs font-bold tracking-widest uppercase rounded">
                    Our Mission
                </div>

                <h2 class="text-3xl md:text-4xl font-black text-[#111618] dark:text-white leading-tight">
                    Pioneering the Future of Conscious Commerce
                </h2>

                <p class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed">
                    To provide our customers with high-quality products that blend functionality with modern aesthetics, ensuring every purchase adds value to your lifestyle. We believe that shopping should be intuitive, inspiring, and ethical.
                </p>

                <p class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed">
                    By leveraging the latest technologies and keeping a close pulse on global design trends, we bring curated excellence directly to your doorstep.
                </p>

                <div class="flex gap-8 pt-4">
                    <div class="flex flex-col">
                        <span class="text-3xl font-black text-primary">10+</span>
                        <span class="text-xs text-gray-500 uppercase font-bold tracking-tighter">Years of Service</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-3xl font-black text-primary">50k+</span>
                        <span class="text-xs text-gray-500 uppercase font-bold tracking-tighter">Happy Customers</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-3xl font-black text-primary">200+</span>
                        <span class="text-xs text-gray-500 uppercase font-bold tracking-tighter">Global Brands</span>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="aspect-square bg-primary/5 rounded-2xl flex items-center justify-center p-4">
                    <div class="w-full h-full rounded-xl overflow-hidden shadow-2xl">
                        <img alt="Professional team in a bright office"
                             class="w-full h-full object-cover"
                             src="{{ asset('admin-assets/img/computer.png') }}">
                    </div>
                </div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-primary/20 rounded-full blur-3xl -z-10"></div>
            </div>
        </div>
    </section>

    <!-- Values Section Header -->
    <div class="px-6 mb-8 text-center">
        <h2 class="text-3xl font-black text-[#111618] dark:text-white tracking-tight">Our Core Values</h2>
        <div class="w-12 h-1 bg-primary mx-auto mt-4 rounded-full"></div>
    </div>

    <!-- Features/Values Grid -->
    <section class="px-6 mb-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="group p-8 rounded-xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900/50 hover:border-primary/30 transition-all hover:shadow-xl hover:shadow-primary/5">
                <div class="w-12 h-12 flex items-center justify-center bg-primary/10 text-primary rounded-lg mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <h3 class="text-xl font-bold text-[#111618] dark:text-white mb-3">Quality Materials</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    We partner with the finest manufacturers globally to ensure durability and premium finish in every piece we offer.
                </p>
            </div>

            <div class="group p-8 rounded-xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900/50 hover:border-primary/30 transition-all hover:shadow-xl hover:shadow-primary/5">
                <div class="w-12 h-12 flex items-center justify-center bg-primary/10 text-primary rounded-lg mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">public</span>
                </div>
                <h3 class="text-xl font-bold text-[#111618] dark:text-white mb-3">Ethical Sourcing</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Responsible production practices are at the heart of everything we do, supporting fair labor and eco-friendly standards.
                </p>
            </div>

            <div class="group p-8 rounded-xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900/50 hover:border-primary/30 transition-all hover:shadow-xl hover:shadow-primary/5">
                <div class="w-12 h-12 flex items-center justify-center bg-primary/10 text-primary rounded-lg mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">ink_pen</span>
                </div>
                <h3 class="text-xl font-bold text-[#111618] dark:text-white mb-3">Design First</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Every product is curated to meet a high standard of visual and functional design, blending beauty with purpose.
                </p>
            </div>

        </div>
    </section>

    <!-- CTA Section -->
    <section class="px-6">
        <div class="bg-gray-900 rounded-2xl p-12 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"></path>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)"></rect>
                </svg>
            </div>

            <div class="relative z-10 max-w-[600px] mx-auto space-y-6">
                <h2 class="text-3xl md:text-4xl font-black">Experience the Difference</h2>
                <p class="text-white/80 text-lg">
                    Ready to upgrade your lifestyle? Discover our latest collection of premium essentials curated just for you.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                    <a href="{{ url('/shop') }}"
                       class="bg-transparent border border-white/40 text-white px-8 py-3 rounded-lg font-bold hover:bg-white/10 transition-colors">
                        Start Shopping
                    </a>

                    {{-- بما إن contact ممكن ما يكون جاهز عندك، خليته يروح /contact --}}
                    <a href="{{ url('/contact') }}"
                       class="bg-transparent border border-white/40 text-white px-8 py-3 rounded-lg font-bold hover:bg-white/10 transition-colors">
                        Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
