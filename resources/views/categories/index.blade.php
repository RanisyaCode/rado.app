<x-app-layout>
    @section('header_title')
        Kelola Kategori
    @endsection

    <div class="space-y-6" x-data="{ createModal: false, editModal: false, activeCategory: null, deleteModal: false, categoryToDelete: null }">
        <!-- Banner -->
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EAF2FF] text-[#4F7DF3] text-xs font-bold mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    <span>Pengelompokan Tugas</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900">Kategori Tugas</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Kelola kategori untuk memisahkan tugas kuliah, pekerjaan, organisasi, belanja, dan pribadi.
                </p>
            </div>

            <button
                type="button"
                @click="createModal = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#4F7DF3] hover:bg-[#3E6DE8] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm shadow-[#4F7DF3]/20 transition-all self-start sm:self-auto active:scale-95"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Kategori Baru</span>
            </button>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($categories as $category)
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-xs hover:border-[#4F7DF3]/40 transition-all flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div
                                class="w-10 h-10 rounded-xl flex items-center justify-center transition-transform group-hover:scale-105"
                                style="background-color: {{ $category->color }}15; color: {{ $category->color }}"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                            </div>

                            <div class="flex items-center gap-1">
                                <button
                                    type="button"
                                    @click="activeCategory = { id: {{ $category->id }}, name: '{{ addslashes($category->name) }}', color: '{{ $category->color }}' }; editModal = true"
                                    class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                    title="Ubah Kategori"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>

                                <button
                                    type="button"
                                    @click="categoryToDelete = { id: {{ $category->id }}, name: '{{ addslashes($category->name) }}' }; deleteModal = true"
                                    class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                    title="Hapus Kategori"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $category->color }}"></span>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-[#4F7DF3] transition-colors">
                                {{ $category->name }}
                            </h3>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-50 flex items-center justify-between text-xs text-slate-500">
                        <span>{{ $category->tasks_count }} tugas terdaftar</span>
                        <span class="w-4 h-4 rounded-full border border-slate-200" style="background-color: {{ $category->color }}"></span>
                    </div>
                </div>
            @endforeach

            <!-- Tanpa Kategori Info Card -->
            <div class="bg-slate-50/70 rounded-2xl p-5 border border-dashed border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-slate-200/60 text-slate-500 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Tanpa Kategori</h3>
                    <p class="text-xs text-slate-500 mt-1">Tugas yang dibuat tanpa memilih kategori tertentu.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/60 text-xs text-slate-500">
                    {{ $uncategorizedCount }} tugas
                </div>
            </div>
        </div>

        <!-- Create Category Modal -->
        <div
            x-show="createModal"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs"
        >
            <div @click.away="createModal = false" class="bg-white rounded-2xl w-full max-w-md p-6 border border-slate-100 shadow-xl">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Tambah Kategori Baru</h3>
                    <button type="button" @click="createModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
                </div>

                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Kategori <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            required
                            placeholder="Misal: Kuliah, Freelance, Belanja..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Warna Tema
                        </label>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach (['#4F7DF3', '#10B981', '#6366F1', '#F59E0B', '#8B5CF6', '#EC4899', '#06B6D4', '#F97316', '#64748B'] as $c)
                                <label class="cursor-pointer">
                                    <input type="radio" name="color" value="{{ $c }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                    <div class="w-7 h-7 rounded-full peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-slate-800 transition-all hover:scale-105" style="background-color: {{ $c }}"></div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                        <button type="button" @click="createModal = false" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl">Batal</button>
                        <button type="submit" class="px-5 py-2 text-xs sm:text-sm font-semibold text-white bg-[#4F7DF3] hover:bg-[#3E6DE8] rounded-xl shadow-sm transition-all">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <div
            x-show="editModal"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs"
        >
            <div @click.away="editModal = false" class="bg-white rounded-2xl w-full max-w-md p-6 border border-slate-100 shadow-xl">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Ubah Kategori</h3>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
                </div>

                <form :action="'/categories/' + activeCategory?.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Kategori
                        </label>
                        <input
                            type="text"
                            name="name"
                            x-model="activeCategory.name"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Warna Tema
                        </label>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach (['#4F7DF3', '#10B981', '#6366F1', '#F59E0B', '#8B5CF6', '#EC4899', '#06B6D4', '#F97316', '#64748B'] as $c)
                                <label class="cursor-pointer">
                                    <input type="radio" name="color" value="{{ $c }}" x-model="activeCategory.color" class="sr-only peer">
                                    <div class="w-7 h-7 rounded-full peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-slate-800 transition-all hover:scale-105" style="background-color: {{ $c }}"></div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                        <button type="button" @click="editModal = false" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl">Batal</button>
                        <button type="submit" class="px-5 py-2 text-xs sm:text-sm font-semibold text-white bg-[#4F7DF3] hover:bg-[#3E6DE8] rounded-xl shadow-sm transition-all">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Category Confirmation -->
        <div
            x-show="deleteModal"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs"
        >
            <div @click.away="deleteModal = false" class="bg-white rounded-2xl w-full max-w-md p-6 border border-slate-100 shadow-xl">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-bold text-slate-900">Hapus Kategori Ini?</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Apakah Anda yakin ingin menghapus kategori <strong class="text-slate-800" x-text="categoryToDelete?.name"></strong>? Tugas yang terkait akan otomatis dialihkan ke status "Tanpa Kategori" dan tidak akan terhapus.
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="deleteModal = false" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl">Batal</button>
                    <form :action="'/categories/' + categoryToDelete?.id" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition-all">Hapus Kategori</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
