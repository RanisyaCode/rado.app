<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $year = (int) $request->get('year', Carbon::now('Asia/Jakarta')->year);
        $month = (int) $request->get('month', Carbon::now('Asia/Jakarta')->month);

        $currentDate = Carbon::createFromDate($year, $month, 1, 'Asia/Jakarta');
        $prevMonth = (clone $currentDate)->subMonth();
        $nextMonth = (clone $currentDate)->addMonth();

        $indonesianMonths = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Start from start of week containing the 1st
        $startOfCalendar = (clone $currentDate)->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar = (clone $currentDate)->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        // Fetch tasks in this date window
        $tasks = Task::with('category')
            ->where('user_id', $user->id)
            ->whereNotNull('due_at')
            ->whereBetween('due_at', [$startOfCalendar->toDateTimeString(), $endOfCalendar->toDateTimeString()])
            ->get();

        $tasksByDate = [];
        foreach ($tasks as $task) {
            $dateKey = $task->due_at->format('Y-m-d');
            $tasksByDate[$dateKey][] = $task;
        }

        // Build calendar matrix
        $calendarDays = [];
        $cursor = clone $startOfCalendar;
        while ($cursor->lte($endOfCalendar)) {
            $dateString = $cursor->format('Y-m-d');
            $calendarDays[] = [
                'date' => clone $cursor,
                'dateString' => $dateString,
                'dayNumber' => $cursor->day,
                'isCurrentMonth' => $cursor->month === $month,
                'isToday' => $cursor->isToday(),
                'tasks' => $tasksByDate[$dateString] ?? []
            ];
            $cursor->addDay();
        }

        $categories = Category::where('user_id', $user->id)->get();
        $selectedDate = $request->get('selected_date', Carbon::now('Asia/Jakarta')->format('Y-m-d'));
        $selectedDateTasks = $tasksByDate[$selectedDate] ?? [];

        return view('calendar.index', compact(
            'year',
            'month',
            'currentDate',
            'prevMonth',
            'nextMonth',
            'indonesianMonths',
            'calendarDays',
            'selectedDate',
            'selectedDateTasks',
            'categories'
        ));
    }
}
