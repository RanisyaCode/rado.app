<x-app-layout>
    @section('header_title')
        Semua Daftar Tugas
    @endsection

    <div class="space-y-6" x-data="{ viewMode: 'card', editModal: false, activeEditTask: null, deleteModal: false, taskToDelete: null }">
        <!-- Search and Filter Bar -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-xs space-y-4">
            <form action="{{ route('tasks.index') }}" method="GET" class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                    <div class="relative w-full sm:max-w-md">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari tugas berdasarkan judul atau deskripsi..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3] bg-[#F7F9FF]/40"
                        >
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                        <!-- View Toggle -->
                        <div class="hidden sm:flex items-center p-1 bg-slate-100 rounded-xl">
                            <button
                                type="button"
                                @click="viewMode = 'card'"
                                :class="viewMode === 'card' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900'"
                                class="p-1.5 rounded-lg text-xs font-semibold transition-all"
                                title="Tampilan Kartu"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            </button>
                            <button
                                type="button"
                                @click="viewMode = 'table'"
                                :class="viewMode === 'table' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900'"
                                class="p-1.5 rounded-lg text-xs font-semibold transition-all"
                                title="Tampilan Tabel"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            </button>
                        </div>

                        <button
                            type="button"
                            @click="createTaskModal = true"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#4F7DF3] hover:bg-[#3E6DE8] text-white text-xs font-semibold rounded-xl shadow-sm shadow-[#4F7DF3]/20 transition-all shrink-0"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah Tugas</span>
                        </button>
                    </div>
                </div>

                <!-- Dropdown Filters -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-2 border-t border-slate-100 text-xs">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
                        <select name="category_id" onchange="this.form.submit()" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-800 bg-white focus:outline-none focus:border-[#4F7DF3]">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                            <option value="uncategorized" {{ request('category_id') === 'uncategorized' ? 'selected' : '' }}>Tanpa Kategori</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status</label>
                        <select name="status" onchange="this.form.submit()" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-800 bg-white focus:outline-none focus:border-[#4F7DF3]">
                            <option value="">Semua Status</option>
                            <option value="Belum Dikerjakan" {{ request('status') === 'Belum Dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                            <option value="Sedang Dikerjakan" {{ request('status') === 'Sedang Dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                            <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Prioritas</label>
                        <select name="priority" onchange="this.form.submit()" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-800 bg-white focus:outline-none focus:border-[#4F7DF3]">
                            <option value="">Semua Prioritas</option>
                            <option value="Rendah" {{ request('priority') === 'Rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="Sedang" {{ request('priority') === 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Tinggi" {{ request('priority') === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Urutkan</label>
                        <select name="sort" onchange="this.form.submit()" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-800 bg-white focus:outline-none focus:border-[#4F7DF3]">
                            <option value="due_asc" {{ request('sort') === 'due_asc' ? 'selected' : '' }}>Tenggat Terdekat</option>
                            <option value="due_desc" {{ request('sort') === 'due_desc' ? 'selected' : '' }}>Tenggat Terjauh</option>
                            <option value="created_desc" {{ request('sort') === 'created_desc' ? 'selected' : '' }}>Terbaru Dibuat</option>
                            <option value="priority_high" {{ request('sort') === 'priority_high' ? 'selected' : '' }}>Prioritas Tertinggi</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Task Content -->
        @if ($tasks->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Tidak ada tugas ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    @if (request()->hasAny(['search', 'category_id', 'status', 'priority']))
                        Coba sesuaikan kata kunci pencarian atau ubah opsi filter di atas.
                    @else
                        Daftar tugas Anda masih kosong. Tambahkan tugas pertama Anda sekarang!
                    @endif
                </p>
                <button
                    type="button"
                    @click="createTaskModal = true"
                    class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-[#4F7DF3] text-white text-xs font-semibold rounded-xl hover:bg-[#3E6DE8]"
                >
                    + Tambah Tugas Sekarang
                </button>
            </div>
        @else
            <!-- CARD VIEW -->
            <div x-show="viewMode === 'card'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($tasks as $task)
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border {{ $task->is_overdue ? 'border-rose-200 shadow-xs' : 'border-slate-100 hover:border-[#4F7DF3]/40 shadow-xs' }} transition-all flex items-start gap-3.5 group">
                        <!-- Checkbox -->
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-6 h-6 rounded-lg flex items-center justify-center border transition-all mt-0.5 {{ $task->status === 'Selesai' ? 'bg-[#4F7DF3] border-[#4F7DF3] text-white' : 'border-slate-300 hover:border-[#4F7DF3] text-transparent' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </form>

                        <div class="flex-1 min-w-0">
                            <!-- Category and priority -->
                            <div class="flex items-center flex-wrap gap-2 mb-1.5 text-xs">
                                @if ($task->category)
                                    <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                                        <span class="w-2 h-2 rounded-full" style="background-color: {{ $task->category->color }}"></span>
                                        <span>{{ $task->category->name }}</span>
                                    </span>
                                    <span class="text-slate-300">·</span>
                                @endif
                                <span class="font-semibold {{ $task->priority === 'Tinggi' ? 'text-rose-600' : ($task->priority === 'Sedang' ? 'text-amber-600' : 'text-slate-500') }}">
                                    {{ $task->priority }}
                                </span>
                                @if ($task->is_overdue)
                                    <span class="text-slate-300">·</span>
                                    <span class="text-rose-600 font-bold text-[11px]">{{ $task->overdue_text }}</span>
                                @endif
                            </div>

                            <h4 class="text-sm font-bold leading-snug {{ $task->status === 'Selesai' ? 'line-through text-slate-400' : 'text-slate-900 group-hover:text-[#4F7DF3]' }} transition-colors">
                                {{ $task->title }}
                            </h4>

                            @if ($task->description)
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                            @endif

                            <!-- Footer -->
                            <div class="flex items-center justify-between mt-3 pt-2.5 border-t border-slate-50 text-xs">
                                <span class="{{ $task->is_overdue ? 'text-rose-600 font-semibold' : 'text-slate-400' }}">
                                    {{ $task->due_at ? $task->due_at->translatedFormat('d M Y, H:i') . ' WIB' : 'Tanpa tenggat' }}
                                </span>

                                <div class="flex items-center gap-1">
                                    <!-- Delete Button Trigger -->
                                    <button
                                        type="button"
                                        @click="taskToDelete = { id: {{ $task->id }}, title: '{{ addslashes($task->title) }}' }; deleteModal = true"
                                        class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                        title="Hapus Tugas"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- TABLE VIEW -->
            <div x-show="viewMode === 'table'" class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                <th class="py-3 px-4 w-10">Status</th>
                                <th class="py-3 px-4">Judul Tugas</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Prioritas</th>
                                <th class="py-3 px-4">Tenggat Waktu</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($tasks as $task)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3 px-4">
                                        <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-5 h-5 rounded-md flex items-center justify-center border transition-all {{ $task->status === 'Selesai' ? 'bg-[#4F7DF3] border-[#4F7DF3] text-white' : 'border-slate-300 text-transparent hover:border-[#4F7DF3]' }}">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="font-semibold text-slate-900 {{ $task->status === 'Selesai' ? 'line-through text-slate-400' : '' }}">
                                            {{ $task->title }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($task->category)
                                            <span class="font-medium text-slate-700">{{ $task->category->name }}</span>
                                        @else
                                            <span class="text-slate-400">Tanpa Kategori</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="font-semibold {{ $task->priority === 'Tinggi' ? 'text-rose-600' : ($task->priority === 'Sedang' ? 'text-amber-600' : 'text-slate-500') }}">
                                            {{ $task->priority }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="{{ $task->is_overdue ? 'text-rose-600 font-bold' : 'text-slate-500' }}">
                                            {{ $task->due_at ? $task->due_at->translatedFormat('d M Y, H:i') : '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <button
                                            type="button"
                                            @click="taskToDelete = { id: {{ $task->id }}, title: '{{ addslashes($task->title) }}' }; deleteModal = true"
                                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        @endif

        <!-- Delete Modal Confirmation -->
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
                        <h3 class="text-base font-bold text-slate-900">Hapus Tugas Ini?</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Apakah Anda yakin ingin menghapus tugas <strong class="text-slate-800" x-text="taskToDelete?.title"></strong>? Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" @click="deleteModal = false" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl">Batal</button>
                    <form :action="'/tasks/' + taskToDelete?.id" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition-all">Hapus Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
