<x-app-layout>
    @section('header_title')
        Tugas Selesai
    @endsection

    <div class="space-y-6" x-data="{ deleteModal: false, taskToDelete: null }">
        <!-- Motivational Banner -->
        <div class="bg-gradient-to-r from-emerald-500/10 via-blue-500/10 to-transparent p-6 rounded-3xl border border-emerald-100/60 bg-white shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Pencapaian Selesai</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900">
                    Hebat! Satu langkah lagi menuju targetmu.
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Kamu telah menyelesaikan sebanyak <strong class="text-emerald-600 font-bold">{{ $tasks->total() }}</strong> tugas hingga saat ini.
                </p>
            </div>
        </div>

        <!-- Filter Search & Date -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs flex flex-col sm:flex-row gap-3 items-center justify-between">
            <form action="{{ route('tasks.completed') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-3 items-center justify-between">
                <div class="relative w-full sm:max-w-md">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari tugas selesai..."
                        class="w-full pl-10 pr-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4F7DF3]/20 focus:border-[#4F7DF3]"
                    >
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <input
                        type="date"
                        name="date"
                        value="{{ request('date') }}"
                        onchange="this.form.submit()"
                        class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs text-slate-700 bg-white focus:outline-none focus:border-[#4F7DF3]"
                    >
                    @if (request()->hasAny(['search', 'date']))
                        <a href="{{ route('tasks.completed') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold px-2 py-1 rounded bg-slate-100">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- List -->
        @if ($tasks->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Belum ada tugas selesai</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Selesaikan tugas dari dashboard atau daftar tugas untuk mencatat rekor produktivitas Anda!
                </p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($tasks as $task)
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-2xs hover:shadow-xs transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-3.5 flex-1 min-w-0">
                            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center flex-wrap gap-2 text-xs mb-1">
                                    @if ($task->category)
                                        <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $task->category->color }}"></span>
                                            <span>{{ $task->category->name }}</span>
                                        </span>
                                        <span class="text-slate-300">·</span>
                                    @endif
                                    <span class="text-slate-500">Prioritas: {{ $task->priority }}</span>
                                </div>

                                <h4 class="text-sm sm:text-base font-bold text-slate-900 line-through decoration-slate-400 decoration-1">
                                    {{ $task->title }}
                                </h4>

                                @if ($task->description)
                                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $task->description }}</p>
                                @endif

                                <div class="flex items-center gap-2 text-[11px] text-slate-400 mt-2">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Selesai pada: {{ $task->completed_at ? $task->completed_at->translatedFormat('d F Y, H:i') : '-' }} WIB</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2 self-end sm:self-center shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 w-full sm:w-auto justify-end">
                            <!-- Kembalikan Status -->
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors"
                                    title="Kembalikan status menjadi belum selesai"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    <span>Kembalikan</span>
                                </button>
                            </form>

                            <!-- Hapus -->
                            <button
                                type="button"
                                @click="taskToDelete = { id: {{ $task->id }}, title: '{{ addslashes($task->title) }}' }; deleteModal = true"
                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors"
                                title="Hapus Tugas"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

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
                        <h3 class="text-base font-bold text-slate-900">Hapus Tugas Selesai Ini?</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Apakah Anda yakin ingin menghapus <strong class="text-slate-800" x-text="taskToDelete?.title"></strong> secara permanen?
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
