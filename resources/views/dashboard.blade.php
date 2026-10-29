<x-app-layout>
    @section('header_title')
        {{ $greeting }}, <span class="text-[#4F7DF3]">{{ explode(' ', $user->name)[0] }}</span>!
    @endsection

    <div class="space-y-6">
        <!-- Welcome Motivation Banner -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5 relative overflow-hidden">
            <div class="absolute right-0 top-0 -mt-10 -mr-10 w-48 h-48 bg-[#EAF2FF] rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 max-w-xl">
                <div class="flex items-center gap-2 text-xs font-semibold text-[#4F7DF3] mb-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Fokus Harian & Produktivitas</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Selamat datang di Rado-App!
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1.5 italic">
                    "{{ $motivation }}"
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-3">
                <button
                    type="button"
                    @click="createTaskModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#4F7DF3] hover:bg-[#3E6DE8] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-md shadow-[#4F7DF3]/20 transition-all active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Tugas Baru</span>
                </button>
            </div>
        </div>

        <!-- 5 Kartu Statistik -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3.5 sm:gap-4">
            <!-- 1. Total Tugas -->
            <a href="{{ route('tasks.index') }}" class="bg-white border border-slate-100 hover:border-[#4F7DF3]/40 p-4 sm:p-5 rounded-2xl transition-all shadow-xs hover:shadow-md hover:shadow-blue-500/5 block">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Tugas</p>
                        <p class="text-2xl sm:text-3xl font-extrabold mt-1 text-slate-900">{{ $total }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-[#EAF2FF] text-[#4F7DF3] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-2.5 pt-2 border-t border-slate-50">Semua tugas tercatat</p>
            </a>

            <!-- 2. Belum Dikerjakan -->
            <a href="{{ route('tasks.index', ['status' => 'Belum Dikerjakan']) }}" class="bg-white border border-slate-100 hover:border-slate-300 p-4 sm:p-5 rounded-2xl transition-all shadow-xs hover:shadow-md block">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Belum Dikerjakan</p>
                        <p class="text-2xl sm:text-3xl font-extrabold mt-1 text-slate-900">{{ $belumDikerjakan }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-2.5 pt-2 border-t border-slate-50">Menunggu antrean</p>
            </a>

            <!-- 3. Sedang Dikerjakan -->
            <a href="{{ route('tasks.index', ['status' => 'Sedang Dikerjakan']) }}" class="bg-white border border-slate-100 hover:border-amber-300 p-4 sm:p-5 rounded-2xl transition-all shadow-xs hover:shadow-md block">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Sedang Jalan</p>
                        <p class="text-2xl sm:text-3xl font-extrabold mt-1 text-slate-900">{{ $sedangDikerjakan }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-2.5 pt-2 border-t border-slate-50">Sedang berlangsung</p>
            </a>

            <!-- 4. Selesai -->
            <a href="{{ route('tasks.completed') }}" class="bg-white border border-slate-100 hover:border-emerald-300 p-4 sm:p-5 rounded-2xl transition-all shadow-xs hover:shadow-md block">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Selesai</p>
                        <p class="text-2xl sm:text-3xl font-extrabold mt-1 text-slate-900">{{ $selesai }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-2.5 pt-2 border-t border-slate-50">Telah tuntas</p>
            </a>

            <!-- 5. Terlambat -->
            <a href="{{ route('tasks.index') }}" class="bg-white border border-slate-100 hover:border-rose-300 p-4 sm:p-5 rounded-2xl transition-all shadow-xs hover:shadow-md block">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Terlambat</p>
                        <p class="text-2xl sm:text-3xl font-extrabold mt-1 {{ $terlambat > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ $terlambat }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-2.5 pt-2 border-t border-slate-50">{{ $terlambat > 0 ? 'Perlu tindakan' : 'Sesuai jadwal' }}</p>
            </a>
        </div>

        <!-- Productivity Progress & Recent Activities (2 Columns) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- D. Progres Produktivitas -->
            <div class="lg:col-span-2 bg-white p-5 sm:p-6 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-[#EAF2FF] text-[#4F7DF3] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Progres Produktivitas</h3>
                                <p class="text-[11px] text-slate-500">{{ $selesai }} dari {{ $total }} tugas telah terselesaikan</p>
                            </div>
                        </div>

                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-black text-[#4F7DF3] tracking-tight">{{ $percentage }}%</span>
                            <span class="text-xs font-semibold text-slate-400">selesai</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden p-0.5 mt-2">
                        <div
                            class="h-full bg-gradient-to-r from-[#4F7DF3] to-[#3B66D6] rounded-full transition-all duration-500 ease-out shadow-xs"
                            style="width: {{ min(100, max(0, $percentage)) }}%"
                        ></div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                    <span class="font-medium text-slate-700 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @if ($total === 0)
                            Belum ada tugas tercatat. Tambahkan tugas pertama Anda!
                        @elseif ($percentage == 100)
                            Luar biasa! Seluruh target pekerjaan Anda tuntas hari ini! 🎉
                        @elseif ($percentage >= 50)
                            Bagus sekali! Sudah separuh perjalanan terlampaui. Tetap fokus!
                        @else
                            Awal yang baik! Selesaikan satu per satu tugas berikutnya.
                        @endif
                    </span>
                    <span class="text-[11px] text-slate-400 font-mono">
                        Rumus: ({{ $selesai }} / {{ $total }}) × 100%
                    </span>
                </div>
            </div>

            <!-- E. Aktivitas Terbaru -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-[#EAF2FF] text-[#4F7DF3] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900">Aktivitas Terbaru</h3>
                        </div>
                        <span class="text-xs font-semibold text-slate-400">{{ $recentActivities->count() }} tercatat</span>
                    </div>

                    @if ($recentActivities->isEmpty())
                        <div class="py-6 text-center text-slate-400 text-xs">
                            Belum ada aktivitas tercatat.
                        </div>
                    @else
                        <div class="space-y-3 max-h-56 overflow-y-auto pr-1 text-xs">
                            @foreach ($recentActivities as $log)
                                <div class="flex items-start gap-2.5">
                                    <div class="w-5 h-5 rounded-full bg-blue-50 text-[#4F7DF3] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-slate-700 font-medium leading-relaxed">{{ $log->description }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- A. Tugas Hari Ini -->
        <div class="space-y-3.5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#4F7DF3]"></div>
                    <h3 class="text-base font-bold text-slate-900">Tugas Hari Ini</h3>
                    <span class="text-xs font-semibold text-slate-400">({{ $todayTasks->count() }})</span>
                </div>

                @if ($todayTasks->isNotEmpty())
                    <a href="{{ route('tasks.today') }}" class="text-xs font-semibold text-[#4F7DF3] hover:underline flex items-center gap-1">
                        <span>Lihat semua</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>

            @if ($todayTasks->isEmpty())
                <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 text-xs text-slate-400">
                    Tidak ada tugas dengan tenggat hari ini. Nikmati harimu atau rencanakan tugas berikutnya!
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    @foreach ($todayTasks as $task)
                        <div class="bg-white rounded-2xl p-4 sm:p-5 border {{ $task->is_overdue ? 'border-rose-200' : 'border-slate-100 hover:border-[#4F7DF3]/40' }} shadow-xs transition-all flex items-start gap-3.5">
                            <!-- Toggle Complete Form -->
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-6 h-6 rounded-lg flex items-center justify-center border transition-all mt-0.5 {{ $task->status === 'Selesai' ? 'bg-[#4F7DF3] border-[#4F7DF3] text-white' : 'border-slate-300 hover:border-[#4F7DF3] text-transparent' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>

                            <div class="flex-1 min-w-0">
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

                                <h4 class="text-sm font-bold {{ $task->status === 'Selesai' ? 'line-through text-slate-400' : 'text-slate-900' }}">
                                    {{ $task->title }}
                                </h4>

                                @if ($task->description)
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                                @endif

                                <div class="flex items-center justify-between mt-3 pt-2.5 border-t border-slate-50 text-xs text-slate-400">
                                    <span>Tenggat: {{ $task->due_at ? $task->due_at->translatedFormat('H:i') . ' WIB' : '-' }}</span>
                                    <span class="font-medium text-slate-700">{{ $task->status }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- B & C. Prioritas Tinggi & Tugas Mendatang -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- C. Tugas Prioritas Tinggi -->
            <div class="space-y-3.5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-rose-500"></div>
                        <h3 class="text-base font-bold text-slate-900">Prioritas Tinggi</h3>
                        <span class="text-xs font-semibold text-rose-600">({{ $highPriorityTasks->count() }})</span>
                    </div>
                </div>

                @if ($highPriorityTasks->isEmpty())
                    <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 text-xs text-slate-400">
                        Tidak ada tugas prioritas tinggi yang belum selesai. Bagus!
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($highPriorityTasks as $task)
                            <div class="bg-white rounded-2xl p-4 border border-slate-100 hover:border-rose-200 transition-all flex items-start justify-between gap-3 shadow-xs">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 text-xs mb-1">
                                        @if ($task->category)
                                            <span class="font-medium text-slate-600">{{ $task->category->name }}</span>
                                            <span class="text-slate-300">·</span>
                                        @endif
                                        <span class="text-rose-600 font-bold">Prioritas Tinggi</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900 truncate">{{ $task->title }}</h4>
                                    <p class="text-xs text-slate-400 mt-1">Tenggat: {{ $task->due_at ? $task->due_at->translatedFormat('d M Y, H:i') : '-' }}</p>
                                </div>

                                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-blue-50 text-[#4F7DF3] hover:bg-blue-100 text-xs font-semibold transition-colors">
                                        Selesaikan
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- B. Tugas Mendatang -->
            <div class="space-y-3.5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-indigo-500"></div>
                        <h3 class="text-base font-bold text-slate-900">Tugas Mendatang</h3>
                        <span class="text-xs font-semibold text-slate-400">({{ $upcomingTasks->count() }})</span>
                    </div>
                </div>

                @if ($upcomingTasks->isEmpty())
                    <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 text-xs text-slate-400">
                        Belum ada tugas terjadwal untuk hari mendatang.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($upcomingTasks as $task)
                            <div class="bg-white rounded-2xl p-4 border border-slate-100 hover:border-[#4F7DF3]/40 transition-all flex items-start justify-between gap-3 shadow-xs">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 text-xs mb-1">
                                        @if ($task->category)
                                            <span class="font-medium text-slate-600">{{ $task->category->name }}</span>
                                            <span class="text-slate-300">·</span>
                                        @endif
                                        <span class="text-slate-500">{{ $task->priority }}</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900 truncate">{{ $task->title }}</h4>
                                    <p class="text-xs text-slate-400 mt-1">Tenggat: {{ $task->due_at ? $task->due_at->translatedFormat('d M Y, H:i') : '-' }}</p>
                                </div>

                                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-blue-50 text-[#4F7DF3] hover:bg-blue-100 text-xs font-semibold transition-colors">
                                        Selesaikan
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
