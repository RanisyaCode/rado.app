<x-guest-layout>
    <div class="mb-4 text-xs text-slate-600 leading-relaxed">
        Lupa kata sandi Anda? Tidak masalah. Masukkan alamat email Anda yang terdaftar dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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
                placeholder="nama@email.com"
                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button
            type="submit"
            class="w-full py-2.5 px-4 rounded-xl text-white font-semibold text-sm bg-[#4F7DF3] hover:bg-[#3E6DE8] shadow-md shadow-[#4F7DF3]/25 transition-all duration-150 active:scale-[0.99]"
        >
            Kirim Tautan Reset Kata Sandi
        </button>

        <div class="pt-2 text-center">
            <a href="{{ route('login') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold">
                Kembali ke Halaman Masuk
            </a>
        </div>
    </form>
</x-guest-layout>
