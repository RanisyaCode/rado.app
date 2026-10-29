<x-app-layout>
    @section('header_title')
        Tugas Hari Ini
    @endsection

    <div class="space-y-6">
        <!-- Banner -->
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EAF2FF] text-[#4F7DF3] text-xs font-bold mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Fokus Tanggal Hari Ini</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900">
                    Agenda: {{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    {{ $tasks->total() }} tugas tercatat dengan tenggat waktu hari ini.
                </p>
            </div>

            <button
                type="button"
                @click="createTaskModal = true"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#4F7DF3] hover:bg-[#3E6DE8] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm shadow-[#4F7DF3]/20 transition-all self-start sm:self-auto"
            >
                + Tambah Tugas Hari Ini
            </button>
        </div>

        @if ($tasks->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Semua Beres Hari Ini!</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Tidak ada tugas tertunda yang memiliki tenggat hari ini. Nikmati harimu atau jadwalkan persiapan tugas esok.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($tasks as $task)
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border {{ $task->is_overdue ? 'border-rose-200' : 'border-slate-100' }} shadow-xs flex items-start gap-3.5">
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-6 h-6 rounded-lg flex items-center justify-center border transition-all mt-0.5 {{ $task->status === 'Selesai' ? 'bg-[#4F7DF3] border-[#4F7DF3] text-white' : 'border-slate-300 hover:border-[#4F7DF3] text-transparent' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </form>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1.5 text-xs">
                                @if ($task->category)
                                    <span class="font-medium text-slate-700">{{ $task->category->name }}</span>
                                    <span class="text-slate-300">·</span>
                                @endif
                                <span class="font-semibold {{ $task->priority === 'Tinggi' ? 'text-rose-600' : 'text-slate-500' }}">{{ $task->priority }}</span>
                            </div>

                            <h4 class="text-sm font-bold {{ $task->status === 'Selesai' ? 'line-through text-slate-400' : 'text-slate-900' }}">
                                {{ $task->title }}
                            </h4>

                            @if ($task->description)
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $task->description }}</p>
                            @endif

                            <div class="mt-3 pt-2 border-t border-slate-50 text-xs text-slate-400 flex items-center justify-between">
                                <span>Jam: {{ $task->due_at ? $task->due_at->translatedFormat('H:i') . ' WIB' : '-' }}</span>
                                <span class="font-medium text-slate-700">{{ $task->status }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
