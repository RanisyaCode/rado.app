<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Task::with('category')->where('user_id', $user->id);

        // Pencarian judul / catatan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter Kategori
        if ($request->filled('category_id')) {
            if ($request->category_id === 'uncategorized') {
                $query->whereNull('category_id');
            } else {
                $query->where('category_id', $request->category_id);
            }
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Prioritas
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Pengurutan
        $sort = $request->get('sort', 'due_asc');
        switch ($sort) {
            case 'due_desc':
                $query->orderBy('due_at', 'desc');
                break;
            case 'created_desc':
                $query->latest();
                break;
            case 'priority_high':
                $query->orderByRaw("CASE priority WHEN 'Tinggi' THEN 1 WHEN 'Sedang' THEN 2 WHEN 'Rendah' THEN 3 ELSE 4 END");
                break;
            default:
                $query->orderByRaw("CASE WHEN due_at IS NULL THEN 1 ELSE 0 END, due_at ASC");
                break;
        }

        $tasks = $query->paginate(8)->withQueryString();
        $categories = Category::where('user_id', $user->id)->get();

        return view('tasks.index', compact('tasks', 'categories', 'sort'));
    }

    public function today(Request $request)
    {
        $user = $request->user();
        $today = Carbon::now('Asia/Jakarta')->toDateString();

        $tasks = Task::with('category')
            ->where('user_id', $user->id)
            ->whereDate('due_at', $today)
            ->orderBy('due_at', 'asc')
            ->paginate(10);

        $categories = Category::where('user_id', $user->id)->get();

        return view('tasks.today', compact('tasks', 'categories', 'today'));
    }

    public function completed(Request $request)
    {
        $user = $request->user();
        $query = Task::with('category')
            ->where('user_id', $user->id)
            ->where('status', 'Selesai');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('completed_at', $request->date);
        }

        $tasks = $query->orderBy('completed_at', 'desc')->paginate(10)->withQueryString();
        $categories = Category::where('user_id', $user->id)->get();

        return view('tasks.completed', compact('tasks', 'categories'));
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        if ($validated['status'] === 'Selesai') {
            $validated['completed_at'] = now();
        }

        $task = Task::create($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'task_id' => $task->id,
            'activity_type' => 'create',
            'description' => 'Membuat tugas baru: "' . $task->title . '"',
        ]);

        return redirect()->back()->with('success', 'Tugas baru berhasil ditambahkan!');
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validated();
        if ($validated['status'] === 'Selesai' && $task->status !== 'Selesai') {
            $validated['completed_at'] = now();
        } elseif ($validated['status'] !== 'Selesai') {
            $validated['completed_at'] = null;
        }

        $task->update($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'task_id' => $task->id,
            'activity_type' => 'update',
            'description' => 'Mengubah tugas: "' . $task->title . '"',
        ]);

        return redirect()->back()->with('success', 'Perubahan tugas berhasil disimpan!');
    }

    public function toggleComplete(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $isDone = $task->status === 'Selesai';
        $newStatus = $isDone ? 'Sedang Dikerjakan' : 'Selesai';

        $task->update([
            'status' => $newStatus,
            'completed_at' => $isDone ? null : now(),
        ]);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'task_id' => $task->id,
            'activity_type' => $isDone ? 'reopen' : 'complete',
            'description' => ($isDone ? 'Mengaktifkan kembali tugas: "' : 'Menyelesaikan tugas: "') . $task->title . '"',
        ]);

        $message = $isDone ? 'Tugas dikembalikan ke Sedang Dikerjakan.' : 'Tugas selesai! Kerja bagus!';
        return redirect()->back()->with('success', $message);
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('delete', $task);

        $title = $task->title;
        $task->delete();

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'task_id' => null,
            'activity_type' => 'delete',
            'description' => 'Menghapus tugas: "' . $title . '"',
        ]);

        return redirect()->back()->with('info', "Tugas \"{$title}\" berhasil dihapus.");
    }
}
