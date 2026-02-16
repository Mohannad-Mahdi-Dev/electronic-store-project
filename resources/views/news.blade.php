<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


</head>

<body class="antialiased">
    <div class="hero-wrap min-h-screen bg-dots-darker bg-center bg-gray-100">
        @if (Route::has('login'))
        <div class="topbar">
            @auth
            <a class="link" href="{{ url('/dashboard') }}">Dashboard</a>
            @else
            <div class="inline-flex" style="gap: 1rem;">
                <a class="link" href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                <a class="link" href="{{ route('register') }}">Register</a>
                @endif
            </div>
            @endauth
        </div>
        @endif

        <div class="flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-xl card p-6">
                <div class="text-center" style="margin-top: .5rem;">

                    <h1 class="text-5xl font-bold text-gray-900" style="margin-top: 1rem;">
                        مرحبًا بك في <span style="text-decoration: underline;">{{ config('app.name', 'Laravel') }}</span>
                    </h1>

                    <p class="text-base muted" style="margin-top: .75rem; line-height: 1.8;">
                        صفحة ترحيبية بسيطة وأنيقة مع أزرار تسجيل الدخول/التسجيل.
                        يمكنك تعديل النصوص والروابط بسهولة.
                    </p>
                </div>

                <div class="divider"></div>

                <div class="grid gap-4">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary transition">
                        الذهاب إلى لوحة التحكم
                        <span aria-hidden="true">→</span>
                    </a>

                    <p class="text-sm muted text-center">
                        أنت مسجّل دخولًا باسم: <strong class="text-gray-700">{{ auth()->user()->name ?? auth()->user()->email }}</strong>
                    </p>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-primary transition">
                        تسجيل الدخول
                        <span aria-hidden="true">→</span>
                    </a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-ghost transition">
                        إنشاء حساب جديد
                    </a>
                    @endif

                    <p class="text-sm muted text-center">
                        لمساعدتك: بعد تسجيل الدخول سيصبح رابط <strong class="text-gray-700">Dashboard</strong> ظاهرًا بالأعلى تلقائيًا.
                    </p>
                    @endauth
                </div>

                <div class="divider"></div>

                <div class="text-center text-sm muted">
                    <span>© {{ date('Y') }}</span>
                    <span>—</span>
                    <span>{{ config('app.name', 'Laravel') }}</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>