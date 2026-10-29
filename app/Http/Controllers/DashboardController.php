<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();

        // Greeting
        $hour = (int) $now->format('H');
        if ($hour >= 4 && $hour < 11) {
            $greeting = 'Selamat pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Selamat siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Selamat sore';
        } else {
            $greeting = 'Selamat malam';
        }

        // Motivations
        $motivations = [
            "Fokuslah pada progres, bukan kesempurnaan.",
            "Setiap langkah kecil membawamu lebih dekat ke target besar.",
            "Mulai hari ini dengan niat dan selesaikan dengan kepuasan.",
            "Disiplin hari ini adalah kebebasan di masa depan.",
            "Satu tugas selesai lebih baik daripada sepuluh rencana tanpa aksi.",
            "Kelola energimu dengan bijak, selesaikan yang paling berdampak dulu."
        ];
        $motivation = $motivations[$now->day % count($motivations)];

        // Statistics
        $allTasks = Task::where('user_id', $user->id)->get();
        $total = $allTasks->count();
        $belumDikerjakan = $allTasks->where('status', 'Belum Dikerjakan')->count();
        $sedangDikerjakan = $allTasks->where('status', 'Sedang Dikerjakan')->count();
        $selesai = $allTasks->where('status', 'Selesai')->count();

        // Terlambat: tenggat < sekarang dan status bukan Selesai
        $terlambat = Task::where('user_id', $user->id)
            ->where('status', '!=', 'Selesai')
            ->whereNotNull('due_at')
            ->where('due_at', '<', $now)
            ->count();

        // Productivity percentage
        $percentage = $total > 0 ? round(($selesai / $total) * 100) : 0;

        // Tugas Hari Ini
        $todayTasks = Task::with('category')
            ->where('user_id', $user->id)
            ->whereDate('due_at', $today)
            ->orderBy('due_at', 'asc')
            ->get();

        // Tugas Mendatang
        $upcomingTasks = Task::with('category')
            ->where('user_id', $user->id)
            ->whereDate('due_at', '>', $today)
            ->where('status', '!=', 'Selesai')
            ->orderBy('due_at', 'asc')
            ->take(6)
            ->get();

        // Tugas Prioritas Tinggi
        $highPriorityTasks = Task::with('category')
            ->where('user_id', $user->id)
            ->where('priority', 'Tinggi')
            ->where('status', '!=', 'Selesai')
            ->orderBy('due_at', 'asc')
            ->take(6)
            ->get();

        // Aktivitas Terbaru
        $recentActivities = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('user_id', $user->id)->get();

        return view('dashboard', compact(
            'user',
            'greeting',
            'motivation',
            'now',
            'total',
            'belumDikerjakan',
            'sedangDikerjakan',
            'selesai',
            'terlambat',
            'percentage',
            'todayTasks',
            'upcomingTasks',
            'highPriorityTasks',
            'recentActivities',
            'categories'
        ));
    }
}
