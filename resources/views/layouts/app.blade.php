<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rado-App') }} - To-Do List & Task Management</title>
    <meta name="description" content="Aplikasi To-Do List dan Task Management modern dengan tema biru pastel, manajemen prioritas, kalender tugas, dan pelacak produktivitas.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F7F9FF] text-[#1E293B] selection:bg-[#4F7DF3] selection:text-white" x-data="{ mobileMenuOpen: false, createTaskModal: false }">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Sidebar Navigation (Desktop & Mobile Drawer) -->
        @include('layouts.navigation')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navbar -->
            <header class="sticky top-0 z-20 bg-[#F7F9FF]/90 backdrop-blur-md border-b border-slate-200/60 px-4 sm:px-6 lg:px-8 py-3.5 transition-all">
                <div class="flex items-center justify-between gap-4">
                    <!-- Left: Mobile Menu Trigger + Title / Date -->
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            @click="mobileMenuOpen = true"
                            class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-white border border-slate-200 shadow-2xs"
                            aria-label="Buka menu navigasi"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>

                        <div>
                            <h1 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight leading-tight">
                                @yield('header_title', 'Rado-App')
                            </h1>
                            <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</span>
                                <span class="text-slate-300">·</span>
                                <span class="text-slate-600 font-medium">Asia/Jakarta</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Quick Actions -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <button
                            type="button"
                            @click="createTaskModal = true"
                            class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 bg-[#4F7DF3] hover:bg-[#3E6DE8] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm shadow-[#4F7DF3]/25 transition-all duration-150 active:scale-95"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Tugas</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-5 p-4 rounded-2xl bg-white border border-emerald-200 text-slate-800 shadow-md shadow-emerald-500/5 flex items-center justify-between gap-3 animate-in fade-in">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-xs sm:text-sm font-medium text-slate-800">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-slate-400 hover:text-slate-600">✕</button>
                    </div>
                @endif

                @if (session('info'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-5 p-4 rounded-2xl bg-white border border-blue-200 text-slate-800 shadow-md shadow-blue-500/5 flex items-center justify-between gap-3 animate-in fade-in">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#4F7DF3] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs sm:text-sm font-medium text-slate-800">{{ session('info') }}</p>
                        </div>
                        <button @click="show = false" class="text-slate-400 hover:text-slate-600">✕</button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 p-4 rounded-2xl bg-white border border-rose-200 text-slate-800 shadow-md shadow-rose-500/5">
                        <div class="flex items-center gap-2 text-rose-600 font-bold text-xs uppercase mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span>Terjadi kesalahan pada input:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs text-rose-600 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Global Modal: Tambah Tugas Baru -->
    <div
        x-show="createTaskModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs"
        @keydown.escape.window="createTaskModal = false"
    >
        <div
            @click.away="createTaskModal = false"
            class="bg-white rounded-2xl w-full max-w-lg border border-slate-100 shadow-xl overflow-hidden flex flex-col max-h-[92vh]"
        >
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-[#F7F9FF]/60">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Tambah Tugas Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola detail tugas, jadwal tenggat, dan prioritas.</p>
                </div>
                <button type="button" @click="createTaskModal = false" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST" class="flex-1 overflow-y-auto p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Judul Tugas <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        required
                        placeholder="Misal: Menyelesaikan Laporan Akhir Praktikum..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Deskripsi Catatan (Opsional)
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Tambahkan detail, checklist kecil, atau catatan penting..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3] resize-none"
                    ></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kategori
                        </label>
                        <select
                            name="category_id"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
                        >
                            <option value="">Tanpa Kategori</option>
                            @php
                                $categoriesList = \App\Models\Category::where('user_id', auth()->id())->get();
                            @endphp
                            @foreach ($categoriesList as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Tingkat Prioritas
                        </label>
                        <select
                            name="priority"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
                        >
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang" selected>Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Tanggal Mulai (Opsional)
                        </label>
                        <input
                            type="datetime-local"
                            name="start_at"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Tenggat Waktu
                        </label>
                        <input
                            type="datetime-local"
                            name="due_at"
                            value="{{ now('Asia/Jakarta')->format('Y-m-d\T18:00') }}"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
                        >
                    </div>
                </div>

                <input type="hidden" name="status" value="Belum Dikerjakan">

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        @click="createTaskModal = false"
                        class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 text-xs sm:text-sm font-semibold text-white bg-[#4F7DF3] hover:bg-[#3E6DE8] rounded-xl shadow-sm shadow-[#4F7DF3]/25 transition-all active:scale-95"
                    >
                        Tambahkan Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
