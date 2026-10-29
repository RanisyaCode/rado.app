<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rado-App') }} - Autentikasi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-[#1E293B] bg-[#F7F9FF] antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8">
        <!-- Brand Header -->
        <div class="flex flex-col items-center mb-6 text-center">
            <a href="/" class="flex flex-col items-center group">
                <div class="w-12 h-12 rounded-2xl bg-[#4F7DF3] flex items-center justify-center text-white shadow-md shadow-[#4F7DF3]/25 mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    rado<span class="text-[#4F7DF3]">.app</span>
                </h1>
            </a>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-xs">
                Aplikasi To-Do List & Task Management Modern Berbasis Laravel Breeze
            </p>
        </div>

        <div class="w-full max-w-md bg-white rounded-3xl border border-slate-100 shadow-xl shadow-blue-500/5 p-6 sm:p-8">
            {{ $slot }}
        </div>

        <div class="mt-6 text-center text-xs text-slate-400">
            Rado-App To-Do List &copy; {{ date('Y') }} · Laravel Breeze Architecture
        </div>
    </div>
</body>
</html>
