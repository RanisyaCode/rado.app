<section class="space-y-4">
    <header>
        <h2 class="text-base font-bold text-rose-900">
            Hapus Akun Pengguna
        </h2>
        <p class="mt-1 text-xs text-rose-700">
            Setelah akun Anda dihapus, seluruh data tugas, kategori, dan riwayat aktivitas Anda akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
        </p>
    </header>

    <div x-data="{ confirmingUserDeletion: false }">
        <button
            type="button"
            @click="confirmingUserDeletion = true"
            class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition-all"
        >
            Hapus Akun Saya Secara Permanen
        </button>

        <div
            x-show="confirmingUserDeletion"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs"
        >
            <div @click.away="confirmingUserDeletion = false" class="bg-white rounded-2xl w-full max-w-md p-6 border border-slate-100 shadow-xl">
                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('delete')

                    <h3 class="text-base font-bold text-slate-900">
                        Apakah Anda yakin ingin menghapus akun?
                    </h3>

                    <p class="text-xs text-slate-500">
                        Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
                    </p>

                    <div>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Kata Sandi Anda"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500"
                        >
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end gap-2.5">
                        <button
                            type="button"
                            @click="confirmingUserDeletion = false"
                            class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl"
                        >
                            Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
