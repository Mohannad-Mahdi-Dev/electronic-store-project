@extends('front.layouts.app')

@section('title', 'Contact Us & Info - Laravel E-commerce')

@section('content')
<main class="flex-grow w-full max-w-[1200px] mx-auto px-4 md:px-10 py-8">

    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a class="text-[#617c89] text-sm font-medium hover:text-primary transition-colors" href="{{ url('/') }}">Home</a>
        <span class="text-[#617c89] text-sm font-medium">/</span>
        <span class="text-primary text-sm font-medium">Contact Us</span>
    </div>

    <!-- Page Heading -->
    <div class="mb-12">
        <h1 class="text-[#111618] dark:text-white text-4xl md:text-5xl font-black leading-tight tracking-[-0.033em] mb-4">Get in Touch</h1>
        <p class="text-[#617c89] dark:text-[#a0aec0] text-lg max-w-2xl">
            We'd love to hear from you. Whether you have a question about features, pricing, or anything else, our team is ready to answer all your questions.
        </p>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

        <!-- Left Side: Contact Form -->
        <section class="space-y-6">
            @if(session('success'))
    <div class="mb-6 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800 font-medium">
        ✅ Message Send Successfuly We Will Send You Soon.
    </div>
@endif
            <form method="POST" action="{{ url('/contact') }}" class="space-y-4">
    @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col flex-1">
                        <p class="text-[#111618] dark:text-white text-sm font-semibold pb-2">Full Name</p>
                        <input class="w-full rounded-lg border border-[#dbe2e6] dark:border-gray-700 bg-white dark:bg-[#1a2b34] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                               name="name" placeholder="John Doe" type="text"/>
                    </div>

                    <div class="flex flex-col flex-1">
                        <p class="text-[#111618] dark:text-white text-sm font-semibold pb-2">Email Address</p>
                        <input class="w-full rounded-lg border border-[#dbe2e6] dark:border-gray-700 bg-white dark:bg-[#1a2b34] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                               name="email" placeholder="name@example.com" type="email"/>
                    </div>
                </div>

                <div class="flex flex-col">
                    <p class="text-[#111618] dark:text-white text-sm font-semibold pb-2">Subject</p>
                    <input class="w-full rounded-lg border border-[#dbe2e6] dark:border-gray-700 bg-white dark:bg-[#1a2b34] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                           name="subject" placeholder="How can we help?" type="text"/>
                </div>

                <div class="flex flex-col">
                    <p class="text-[#111618] dark:text-white text-sm font-semibold pb-2">Message</p>
                    <textarea class="w-full rounded-lg border border-[#dbe2e6] dark:border-gray-700 bg-white dark:bg-[#1a2b34] dark:text-white p-4 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-none"
                              name="message" placeholder="Write your message here..." rows="5"></textarea>
                </div>

                <button class="bg-primary text-white font-bold py-3 px-8 rounded-lg hover:brightness-110 active:scale-95 transition-all w-full md:w-auto"
                        type="submit">
                    Send Message
                </button>
            </form>
        </section>

        <!-- Right Side: Contact Info -->
        <section class="space-y-8">
            <div class="bg-white dark:bg-[#1a2b34] p-8 rounded-xl border border-[#f0f3f4] dark:border-gray-800 shadow-sm">
                <h3 class="text-xl font-bold mb-6">Contact Information</h3>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="bg-primary/10 text-primary p-3 rounded-lg">
                            <span class="material-symbols-outlined">location_on</span>
                        </div>
                        <div>
                            <p class="font-semibold text-[#111618] dark:text-white">Our Office</p>
                            <p class="text-[#617c89] dark:text-[#a0aec0] text-sm leading-relaxed">
                                Electro E-commerce Ave, Suite 400<br/>Sana'a City, CA 94043, YEM
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="bg-primary/10 text-primary p-3 rounded-lg">
                            <span class="material-symbols-outlined">mail</span>
                        </div>
                        <div>
                            <p class="font-semibold text-[#111618] dark:text-white">Email Us</p>
                            <p class="text-[#617c89] dark:text-[#a0aec0] text-sm">ُEbraheem@gmail.com</p>
                            <p class="text-[#617c89] dark:text-[#a0aec0] text-sm">ُEbrahee77m@gmail.com</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="bg-primary/10 text-primary p-3 rounded-lg">
                            <span class="material-symbols-outlined">call</span>
                        </div>
                        <div>
                            <p class="font-semibold text-[#111618] dark:text-white">Phone Number</p>
                            <p class="text-[#617c89] dark:text-[#a0aec0] text-sm">+967-777241186</p>
                            <p class="text-[#617c89] dark:text-[#a0aec0] text-sm">Mon - Fri, 9am - 6pm EST</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Static Map Placeholder -->
            <div class="w-full h-48 rounded-xl overflow-hidden bg-gray-200 relative">
                <div class="absolute inset-0 bg-cover bg-center opacity-80"
                     style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuB3ViErWVqWEyoa32feNKGEbgwU1nJRyjQMkd1gTX8vEn7V4JEfZz03eHM_q6X2qW4a0L0g1CwDUEI2IZn66z72_04HoNBj9FYrfvF0CIK_G0753gTgEE3dJhN7oFx3OBamkyeKrEnSCbu5L5NlrTCrOc-4Qm6_IhQQ_bHW4YuSG1hgVbH7p6lV7RzAigL56k2kJE2LzqTri0QJQemMYK7kzdOR1K7j__6vjZFk1GxbdPX8VILOsKy0ZkfenOj6JnxwtmBEdDzRJd8');">
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-white dark:bg-background-dark p-2 rounded-full shadow-lg border-2 border-primary">
                        <span class="material-symbols-outlined text-primary text-3xl">push_pin</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Minimal 404/Fallback Section -->
    <section class="mt-20 py-10 border-t border-[#f0f3f4] dark:border-gray-800">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-primary/5 dark:bg-primary/10 p-8 rounded-2xl">
            <div class="text-center md:text-left">
                <h4 class="text-xl font-bold mb-2">Looking for something else?</h4>
                <p class="text-[#617c89] dark:text-[#a0aec0]">Can't find the product or page you need? Our search might help.</p>
            </div>
            <div class="flex gap-4">
                <a class="px-6 py-2 border-2 border-primary text-primary font-semibold rounded-lg hover:bg-primary hover:text-white transition-all text-sm"
                   href="#">
                    Visit FAQ
                </a>
                <a class="px-6 py-2 bg-primary text-white font-semibold rounded-lg hover:brightness-110 transition-all text-sm"
                   href="#">
                    Go to Search
                </a>
            </div>
        </div>
    </section>

</main>
@endsection
