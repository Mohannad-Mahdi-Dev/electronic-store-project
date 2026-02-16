<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('Team Coder', 'ElectroStore') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('admin-assets/css/style-welcome.css') }}">
</head>

<body class="antialiased">    <div class="hero-wrap min-h-screen bg-dots-darker bg-center bg-gray-100">

        {{-- Topbar --}}
        <div class="topbar">
            <div class="inline-flex" style="gap:.75rem; align-items:center;">
                <span class="badge"><img src="{{ asset('admin-assets/img/AdminLogo.png  with=100px, height=100px') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"><span>ElectroStore</span></span>
            </div>

            @if (Route::has('login'))
            <div class="inline-flex" style="gap: 1rem; align-items:center;">
                @auth
                @php
                $role = (int) (auth()->user()->role_id ?? 3);
                $isAdminPanel = in_array($role, [1,2]);
                @endphp

                @if($isAdminPanel)
                <a class="link" href="{{ url('/dashboard') }}">لوحة التحكم</a>
                @else
                <a class="link" href="{{ url('/') }}">الرئيسية</a>
                @endif

                <a class="link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
                @else
                <a class="link" href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                <a class="link" href="{{ route('register') }}">Register</a>
                @endif
                @endauth
            </div>
            @endif
        </div>

        {{-- Content --}}
        <div class="flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-3xl card p-6">

                <div class="text-center" style="margin-top: .5rem;">

                    <h1 class="text-5xl font-bold text-gray-900" style="margin-top: 1rem;">
                     <span style="text-decoration: underline;">{{ config('Team Coder', 'ElectroStore') }}</span>
                    </h1>

                    {{-- <p class="text-base muted" style="margin-top: .75rem; line-height: 1.8;">
                        هذه الصفحة هي نقطة البداية للـ Front-End. من هنا تضع روابط صفحاتك وتبني الواجهات.
                        (Products / Categories / Orders / Customers / Dashboard)
                    </p> --}}
                </div>

                <div class="divider"></div>

                {{-- Quick links section --}}
                <div class="grid gap-4">
                    {{-- <div class="section-title text-xl">روابط سريعة لبناء الواجهات</div> --}}

                    <div class="menu">
                        {{-- هذه الروابط تعمل فقط إذا أنت مسجّل دخول وصلاحيتك 1 أو 2 --}}
                        @auth
                        @php
                        $role = (int) (auth()->user()->role_id ?? 3);
                        $isAdminPanel = in_array($role, [1,2]);
                        @endphp

                        @if($isAdminPanel)
                        <a class="tile transition" href="{{ url('/dashboard') }}">📊 Dashboard</a>
                        <a class="tile transition" href="{{ url('/categories') }}">🏷️ Category</a>
                        <a class="tile transition" href="{{ url('/sub-categories') }}">📑 Sub Category</a>
                        <a class="tile transition" href="{{ url('/brands') }}">™️ Brands</a>
                        <a class="tile transition" href="{{ url('/products') }}">📦 Products</a>
                        <a class="tile transition" href="{{ url('/shipping') }}">🚚 Shipping</a>
                        <a class="tile transition" href="{{ url('/orders') }}">🧾 Orders</a>
                        <a class="tile transition" href="{{ url('/discounts') }}">💰 Discount</a>
                        {{-- <a class="tile transition" href="{{ url('/customers') }}">👥 Users</a> --}}
                        <a class="tile transition" href="{{ url('/pages') }}">📄 Pages</a>

                        {{-- Super Admin Only --}}
                        @if($role === 1)
                        <a class="tile transition" href="{{ url('/super-admins') }}">🛡️ Super Admins</a>
                        <a class="tile transition" href="{{ url('/sub-admins') }}">👮 Sub Admins</a>
                        <a class="tile transition" href="{{ url('/customers') }}">👥 Customers</a>
                        {{-- <a class="tile transition" href="{{ url('/') }}">👥 Users</a> --}}
                        @endif
                        @else
                        <div class="tile">
                             أنت User (role_id = 3). لا توجد لوحة إدارة هنا.
                            إذا تريد صفحة مستخدم خاصة، نضيف routes و views لها.
                        </div>
                        @endif
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary transition">تسجيل الدخول →</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-ghost transition">إنشاء حساب جديد</a>
                        @endif
                        @endauth
                    </div>

                    {{-- <p class="text-sm muted">
                        ملاحظة: لو تريد واجهات للمستخدم العادي (role_id=3) مثل صفحة متجر/منتجات عامة،
                        قلّي ونعمل Routes + Views خاصة بالمستخدمين.
                    </p> --}}
                </div>

                <div class="divider"></div>

                <div class="text-center text-sm muted">
                    <span>© {{ date('Y') }}</span>
                    <span>—</span>
                    <span>{{ config('Team Coder', 'ElectroStore') }}</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>