@php
    $user = auth()->user();

    $todayCount = \App\Models\Task::where('user_id', $user->id)
        ->whereDate('due_at', now('Asia/Jakarta')->toDateString())
        ->where('status', '!=', 'Selesai')
        ->count();

    $totalActive = \App\Models\Task::where('user_id', $user->id)
        ->where('status', '!=', 'Selesai')
        ->count();

    $completedCount = \App\Models\Task::where('user_id', $user->id)
        ->where('status', 'Selesai')
        ->count();
@endphp

{{-- MOBILE BACKDROP --}}
<div
    x-show="mobileMenuOpen"
    x-cloak
    @click="mobileMenuOpen = false"
    class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-xs lg:hidden"
    aria-hidden="true"
></div>

{{-- SIDEBAR --}}
<aside
    class="fixed left-0 top-0 z-40 flex h-screen w-64 flex-col justify-between border-r border-slate-100 bg-white transition-transform duration-300 ease-in-out lg:sticky lg:translate-x-0"
    :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>

    {{-- TOP HEADER & NAVIGATION --}}
    <div class="flex flex-1 flex-col overflow-y-auto px-4 py-5">

        {{-- BRAND LOGO --}}
        <div class="mb-6 flex items-center justify-between px-2">

            <a href="{{ route('dashboard') }}"
                class="group flex items-center gap-2.5">

                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#4F7DF3] text-white shadow-sm shadow-[#4F7DF3]/30">
                    <svg class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2.5"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>

                <div class="flex flex-col">
                    <span class="text-lg font-bold leading-none tracking-tight text-slate-900">
                        rado<span class="text-[#4F7DF3]">.app</span>
                    </span>

                    <span class="mt-0.5 text-[11px] font-medium text-slate-400">
                        Task Management
                    </span>
                </div>
            </a>

            {{-- MOBILE CLOSE BUTTON --}}
            <button
                type="button"
                @click="mobileMenuOpen = false"
                class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 lg:hidden"
            >
                ✕
            </button>

        </div>

        {{-- NAVIGATION LINKS --}}
        <nav class="space-y-1">

            <div class="px-2 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                Menu Utama
            </div>

            {{-- DASHBOARD --}}
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-[#EAF2FF] font-semibold text-[#4F7DF3]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 {{ request()->routeIs('dashboard') ? 'text-[#4F7DF3]' : 'text-slate-400' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                        />
                    </svg>
                    <span>Dashboard</span>
                </div>
            </a>

            {{-- SEMUA TUGAS --}}
            <a
                href="{{ route('tasks.index') }}"
                class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('tasks.index') ? 'bg-[#EAF2FF] font-semibold text-[#4F7DF3]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 {{ request()->routeIs('tasks.index') ? 'text-[#4F7DF3]' : 'text-slate-400' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                        />
                    </svg>
                    <span>Semua Tugas</span>
                </div>

                @if ($totalActive > 0)
                    <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ request()->routeIs('tasks.index') ? 'bg-[#4F7DF3] text-white' : 'bg-slate-100 text-slate-600' }}">
                        {{ $totalActive }}
                    </span>
                @endif
            </a>

            {{-- TUGAS HARI INI --}}
            <a
                href="{{ route('tasks.today') }}"
                class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('tasks.today') ? 'bg-[#EAF2FF] font-semibold text-[#4F7DF3]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 {{ request()->routeIs('tasks.today') ? 'text-[#4F7DF3]' : 'text-slate-400' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <span>Tugas Hari Ini</span>
                </div>

                @if ($todayCount > 0)
                    <span class="rounded-full bg-[#4F7DF3] px-2 py-0.5 text-xs font-bold text-white">
                        {{ $todayCount }}
                    </span>
                @endif
            </a>

            {{-- KALENDER --}}
            <a
                href="{{ route('calendar') }}"
                class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('calendar') ? 'bg-[#EAF2FF] font-semibold text-[#4F7DF3]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 {{ request()->routeIs('calendar') ? 'text-[#4F7DF3]' : 'text-slate-400' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                    <span>Kalender</span>
                </div>
            </a>

            {{-- KATEGORI --}}
            <a
                href="{{ route('categories.index') }}"
                class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('categories.index') ? 'bg-[#EAF2FF] font-semibold text-[#4F7DF3]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 {{ request()->routeIs('categories.index') ? 'text-[#4F7DF3]' : 'text-slate-400' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"
                        />
                    </svg>
                    <span>Kategori</span>
                </div>
            </a>

            {{-- TUGAS SELESAI --}}
            <a
                href="{{ route('tasks.completed') }}"
                class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('tasks.completed') ? 'bg-[#EAF2FF] font-semibold text-[#4F7DF3]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 {{ request()->routeIs('tasks.completed') ? 'text-[#4F7DF3]' : 'text-slate-400' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <span>Tugas Selesai</span>
                </div>

                @if ($completedCount > 0)
                    <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">
                        {{ $completedCount }}
                    </span>
                @endif
            </a>

            {{-- PENGATURAN --}}
            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition-all {{ request()->routeIs('profile.edit') ? 'bg-[#EAF2FF] font-semibold text-[#4F7DF3]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="h-4 w-4 {{ request()->routeIs('profile.edit') ? 'text-[#4F7DF3]' : 'text-slate-400' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                    <span>Pengaturan</span>
                </div>
            </a>

        </nav>
    </div>

    {{-- USER PROFILE & LOGOUT --}}
    <div
        class="border-t border-slate-100 bg-white p-4"
        x-data="{ logoutModalOpen: false }"
    >

        <div class="flex items-center justify-between gap-3">

            {{-- USER PROFILE --}}
            <a href="{{ route('profile.edit') }}"
                class="group flex min-w-0 flex-1 items-center gap-3 overflow-hidden text-left transition-opacity hover:opacity-85">

                <img
                    src="{{ $user->profile_photo
                        ? asset('storage/' . $user->profile_photo)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=4F7DF3&color=fff&size=150' }}"
                    alt="{{ $user->name }}"
                    class="h-9 w-9 rounded-full object-cover ring-2 ring-[#EAF2FF]"
                    style="width: 36px; height: 36px; min-width: 36px; object-fit: cover;"
                >

                <div class="min-w-0 flex-1">
                    <p class="truncate text-xs font-semibold text-slate-800 transition-colors group-hover:text-[#4F7DF3]">
                        {{ $user->name }}
                    </p>

                    <p class="truncate text-[11px] text-slate-400">
                        {{ $user->email }}
                    </p>
                </div>
            </a>

            {{-- LOGOUT BUTTON --}}
            <button
                type="button"
                @click="logoutModalOpen = true"
                class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-rose-50 hover:text-rose-600"
                title="Keluar dari Akun"
                aria-label="Logout"
            >
                <svg class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                    />
                </svg>
            </button>

        </div>

        {{-- LOGOUT MODAL: DITELEPORT KE BODY --}}
        <template x-teleport="body">

            <div
                x-cloak
                x-show="logoutModalOpen"
                x-transition.opacity.duration.200ms
                @keydown.escape.window="logoutModalOpen = false"
                @click.self="logoutModalOpen = false"
                class="fixed inset-0 z-[99999] flex items-center justify-center bg-slate-950/50 p-4"
                style="display: none;"
            >

                <div class="relative w-full max-w-[340px] rounded-2xl bg-white p-5 shadow-2xl mx-auto flex-shrink-0">

                {{-- MODAL CARD --}}
                <div
                    x-show="logoutModalOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="scale-90 opacity-0"
                    x-transition:enter-end="scale-100 opacity-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="scale-100 opacity-100"
                    x-transition:leave-end="scale-90 opacity-0"
                    @click.stop
                    class="w-full max-w-[360px] rounded-2xl bg-white p-6 shadow-2xl"
                >

                    {{-- MODAL ICON --}}
                    <div class="flex justify-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-rose-50">
                            <svg class="h-7 w-7 text-rose-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>
                        </div>
                    </div>

                    {{-- MODAL TEXT --}}
                    <div class="mt-4 text-center">
                        <h3 class="text-lg font-bold text-slate-900">
                            Yakin ingin logout?
                        </h3>

                        <p class="mt-2 text-sm leading-relaxed text-slate-500">
                            Apakah Anda yakin ingin keluar dari akun
                            <span class="font-semibold text-slate-700">
                                {{ $user->name }}
                            </span>?
                            Anda perlu login kembali untuk mengakses akun.
                        </p>
                    </div>

                    {{-- MODAL BUTTONS --}}
                    <div class="mt-6 flex items-center gap-3">

                        {{-- CANCEL --}}
                        <button
                            type="button"
                            @click="logoutModalOpen = false"
                            class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            Batal
                        </button>

                        {{-- CONFIRM LOGOUT --}}
                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                            class="flex-1"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-600"
                            >
                                Ya, Logout
                            </button>
                        </form>

                    </div>

                </div>
            </div>

        </template>

    </div>

</aside>
