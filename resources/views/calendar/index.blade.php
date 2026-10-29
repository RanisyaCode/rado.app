<x-app-layout>
    @section('header_title')
        Kalender Tugas
    @endsection

    <div class="space-y-6" x-data="{ selectedDate: '{{ $selectedDate }}' }">
        <!-- Calendar Header with Controls -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#EAF2FF] text-[#4F7DF3] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900 tracking-tight">
                        {{ $indonesianMonths[$month] }} {{ $year }}
                    </h2>
                    <p class="text-xs text-slate-500">Jadwal tugas berdasarkan tanggal tenggat waktu</p>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a
                    href="{{ route('calendar', ['year' => now('Asia/Jakarta')->year, 'month' => now('Asia/Jakarta')->month]) }}"
                    class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors"
                >
                    Hari Ini
                </a>

                <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-white">
                    <a
                        href="{{ route('calendar', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
                        class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors"
                        aria-label="Bulan sebelumnya"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                    <div class="w-px h-5 bg-slate-200"></div>
                    <a
                        href="{{ route('calendar', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
                        class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors"
                        aria-label="Bulan berikutnya"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <button
                    type="button"
                    @click="createTaskModal = true"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-[#4F7DF3] hover:bg-[#3E6DE8] rounded-xl shadow-2xs transition-all"
                >
                    + Tugas Baru
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Calendar Grid -->
            <div class="lg:col-span-2 bg-white p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-xs">
                <!-- Weekdays -->
                <div class="grid grid-cols-7 mb-2 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                    <div class="py-2 text-rose-500">Min</div>
                    <div class="py-2">Sen</div>
                    <div class="py-2">Sel</div>
                    <div class="py-2">Rab</div>
                    <div class="py-2">Kam</div>
                    <div class="py-2">Jum</div>
                    <div class="py-2">Sab</div>
                </div>

                <!-- Grid Cells -->
                <div class="grid grid-cols-7 gap-1 sm:gap-1.5">
                    @foreach ($calendarDays as $day)
                        <a
                            href="{{ route('calendar', ['year' => $year, 'month' => $month, 'selected_date' => $day['dateString']]) }}"
                            class="min-h-[70px] sm:min-h-[85px] p-1.5 sm:p-2 rounded-xl border transition-all flex flex-col justify-between {{ $selectedDate === $day['dateString'] ? 'border-[#4F7DF3] bg-[#EAF2FF]/50 ring-2 ring-[#4F7DF3]/20 shadow-xs' : ($day['isToday'] ? 'border-[#4F7DF3]/60 bg-blue-50/20' : ($day['isCurrentMonth'] ? 'border-slate-100 bg-white hover:border-slate-200 hover:bg-slate-50/60' : 'border-slate-50 bg-slate-50/40 opacity-40 hover:opacity-75')) }}"
                        >
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full {{ $day['isToday'] ? 'bg-[#4F7DF3] text-white' : ($selectedDate === $day['dateString'] ? 'text-[#4F7DF3]' : ($day['isCurrentMonth'] ? 'text-slate-800' : 'text-slate-400')) }}">
                                    {{ $day['dayNumber'] }}
                                </span>

                                @if (count($day['tasks']) > 0)
                                    <span class="text-[10px] font-bold text-slate-500 px-1 rounded-sm bg-slate-100">
                                        {{ count($day['tasks']) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Preview Tasks -->
                            <div class="space-y-1 mt-1 overflow-hidden">
                                @foreach (array_slice($day['tasks'], 0, 2) as $t)
                                    <div
                                        class="px-1.5 py-0.5 rounded text-[10px] truncate font-medium flex items-center gap-1 {{ $t->status === 'Selesai' ? 'bg-slate-100 text-slate-500 line-through' : ($t->is_overdue ? 'bg-rose-100 text-rose-800 font-semibold' : 'bg-[#EAF2FF] text-[#4F7DF3]') }}"
                                        title="{{ $t->title }}"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: {{ $t->category->color ?? '#4F7DF3' }}"></span>
                                        <span class="truncate">{{ $t->title }}</span>
                                    </div>
                                @endforeach
                                @if (count($day['tasks']) > 2)
                                    <div class="text-[9px] text-slate-400 font-semibold pl-1">
                                        +{{ count($day['tasks']) - 2 }} lainnya
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Inspector for selected date -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div>
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Agenda Tanggal</span>
                            <h3 class="text-base font-bold text-slate-900 mt-0.5">
                                {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
                            </h3>
                        </div>
                    </div>

                    <div class="mt-4 space-y-3 max-h-96 overflow-y-auto">
                        @if (empty($selectedDateTasks))
                            <div class="py-12 text-center text-slate-400 text-xs">
                                <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z"/></svg>
                                <p>Tidak ada jadwal tugas pada tanggal ini.</p>
                                <button
                                    type="button"
                                    @click="createTaskModal = true"
                                    class="mt-3 text-[#4F7DF3] font-semibold hover:underline block mx-auto"
                                >
                                    + Jadwalkan Tugas Sekarang
                                </button>
                            </div>
                        @else
                            @foreach ($selectedDateTasks as $t)
                                <div class="p-3 rounded-xl border border-slate-100 hover:border-[#4F7DF3]/40 bg-slate-50/50 hover:bg-white transition-all group">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            @if ($t->category)
                                                <span class="w-2 h-2 rounded-full" style="background-color: {{ $t->category->color }}"></span>
                                                <span class="text-xs font-semibold text-slate-600">{{ $t->category->name }}</span>
                                            @else
                                                <span class="text-xs text-slate-400">Tanpa Kategori</span>
                                            @endif
                                        </div>

                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded {{ $t->priority === 'Tinggi' ? 'bg-rose-50 text-rose-700' : ($t->priority === 'Sedang' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                            {{ $t->priority }}
                                        </span>
                                    </div>

                                    <h4 class="text-sm font-bold mt-1.5 leading-snug {{ $t->status === 'Selesai' ? 'line-through text-slate-400' : 'text-slate-900 group-hover:text-[#4F7DF3]' }} transition-colors">
                                        {{ $t->title }}
                                    </h4>

                                    <div class="flex items-center justify-between text-[11px] text-slate-400 mt-2 pt-2 border-t border-slate-100">
                                        <span>{{ $t->due_at ? $t->due_at->translatedFormat('H:i') . ' WIB' : '-' }}</span>
                                        <form action="{{ route('tasks.toggle', $t) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs font-semibold px-2 py-0.5 rounded {{ $t->status === 'Selesai' ? 'text-emerald-700 bg-emerald-50' : 'text-[#4F7DF3] bg-blue-50' }}">
                                                {{ $t->status === 'Selesai' ? 'Selesai ✓' : 'Selesaikan' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
