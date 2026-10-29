<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-900">Masuk ke Akun Anda</h2>
        <p class="text-xs text-slate-500 mt-1">Kelola seluruh tugas dan tingkatkan produktivitas harianmu.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                Alamat Email
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="nama@email.com"
                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                    Kata Sandi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#4F7DF3] hover:underline">
                        Lupa Kata Sandi?
                    </a>
                @endif
            </div>

            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-slate-300 text-[#4F7DF3] shadow-sm focus:ring-[#4F7DF3]"
                >
                <span class="ms-2 text-xs text-slate-600 font-medium">Ingat Saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full py-2.5 px-4 rounded-xl text-white font-semibold text-sm bg-[#4F7DF3] hover:bg-[#3E6DE8] shadow-md shadow-[#4F7DF3]/25 transition-all duration-150 active:scale-[0.99] flex items-center justify-center gap-2"
        >
            <span>Masuk</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </button>
    </form>

    <!-- Quick Demo Login Option -->
    <div class="mt-6 pt-5 border-t border-slate-100">
        <a
            href="{{ route('demo.login') }}"
            class="w-full py-2 px-3 rounded-xl border border-blue-200 bg-[#EAF2FF] hover:bg-blue-100 text-[#4F7DF3] text-xs font-bold transition-all flex items-center justify-center gap-2"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>Masuk Cepat sebagai Rani Syaeka (Demo)</span>
        </a>
    </div>

    <!-- Register Link -->
    <div class="mt-4 text-center text-xs text-slate-500">
        Belum memiliki akun?
        <a href="{{ route('register') }}" class="font-bold text-[#4F7DF3] hover:underline">
            Daftar Sekarang
        </a>
    </div>
</x-guest-layout>
