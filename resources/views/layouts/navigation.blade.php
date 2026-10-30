@php
    use App\Models\Task;
@endphp

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

<!-- Mobile Backdrop -->
<div
    x-show="mobileMenuOpen"
    x-cloak
    @click="mobileMenuOpen = false"
    class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-40 lg:hidden"
    aria-hidden="true"
></div>

<!-- Sidebar -->
<aside
    class="fixed lg:sticky top-0 left-0 h-screen w-64 bg-white border-r border-slate-100 flex flex-col justify-between z-40 transition-transform duration-300 ease-in-out lg:translate-x-0"
    :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <!-- Top Header & Navigation -->
    <div class="flex flex-col flex-1 overflow-y-auto px-4 py-5">
        <!-- Brand Logo -->
        <div class="flex items-center justify-between px-2 mb-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-[#4F7DF3] flex items-center justify-center text-white shadow-sm shadow-[#4F7DF3]/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-lg tracking-tight text-slate-900 leading-none">
                        rado<span class="text-[#4F7DF3]">.app</span>
                    </span>
                    <span class="text-[11px] font-medium text-slate-400 mt-0.5">Task Management</span>
                </div>
            </a>

            <!-- Mobile Close Button -->
            <button
                type="button"
                @click="mobileMenuOpen = false"
                class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100"
            >
                ✕
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1">
            <div class="px-2 pb-2 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">
                Menu Utama
            </div>

            <!-- Dashboard -->
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-[#EAF2FF] text-[#4F7DF3] font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-[#4F7DF3]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </div>
            </a>

            <!-- Semua Tugas -->
            <a
                href="{{ route('tasks.index') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('tasks.index') ? 'bg-[#EAF2FF] text-[#4F7DF3] font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('tasks.index') ? 'text-[#4F7DF3]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span>Semua Tugas</span>
                </div>
                @if ($totalActive > 0)
                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ request()->routeIs('tasks.index') ? 'bg-[#4F7DF3] text-white' : 'bg-slate-100 text-slate-600' }}">
                        {{ $totalActive }}
                    </span>
                @endif
            </a>

            <!-- Tugas Hari Ini -->
            <a
                href="{{ route('tasks.today') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('tasks.today') ? 'bg-[#EAF2FF] text-[#4F7DF3] font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('tasks.today') ? 'text-[#4F7DF3]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Tugas Hari Ini</span>
                </div>
                @if ($todayCount > 0)
                    <span class="text-xs px-2 py-0.5 rounded-full font-bold bg-[#4F7DF3] text-white">
                        {{ $todayCount }}
                    </span>
                @endif
            </a>

            <!-- Kalender -->
            <a
                href="{{ route('calendar') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('calendar') ? 'bg-[#EAF2FF] text-[#4F7DF3] font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('calendar') ? 'text-[#4F7DF3]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Kalender</span>
                </div>
            </a>

            <!-- Kategori -->
            <a
                href="{{ route('categories.index') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('categories.index') ? 'bg-[#EAF2FF] text-[#4F7DF3] font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('categories.index') ? 'text-[#4F7DF3]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    <span>Kategori</span>
                </div>
            </a>

            <!-- Tugas Selesai -->
            <a
                href="{{ route('tasks.completed') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('tasks.completed') ? 'bg-[#EAF2FF] text-[#4F7DF3] font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('tasks.completed') ? 'text-[#4F7DF3]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Tugas Selesai</span>
                </div>
                @if ($completedCount > 0)
                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold bg-emerald-50 text-emerald-700">
                        {{ $completedCount }}
                    </span>
                @endif
            </a>

            <!-- Pengaturan -->
            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('profile.edit') ? 'bg-[#EAF2FF] text-[#4F7DF3] font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ request()->routeIs('profile.edit') ? 'text-[#4F7DF3]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Pengaturan</span>
                </div>
            </a>
        </nav>
    </div>

    <!-- User Profile & Logout Bottom Bar -->
    <div class="p-4 border-t border-slate-100 bg-white">
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 text-left overflow-hidden group flex-1 hover:opacity-85 transition-opacity">
                <img
                    src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80"
                    alt="{{ $user->name }}"
                    class="w-9 h-9 rounded-full object-cover ring-2 ring-[#EAF2FF]"
                >
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-slate-800 truncate group-hover:text-[#4F7DF3] transition-colors">
                        {{ $user->name }}
                    </p>
                    <p class="text-[11px] text-slate-400 truncate">{{ $user->email }}</p>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                    title="Keluar dari Akun"
                    aria-label="Logout"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>
