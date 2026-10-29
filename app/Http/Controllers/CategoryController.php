<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\ActivityLog;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $categories = Category::withCount('tasks')
            ->where('user_id', $user->id)
            ->get();

        $uncategorizedCount = Task::where('user_id', $user->id)
            ->whereNull('category_id')
            ->count();

        return view('categories.index', compact('categories', 'uncategorizedCount'));
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $validated['color'] = $validated['color'] ?? '#4F7DF3';
        $validated['icon'] = $validated['icon'] ?? 'Folder';

        $category = Category::create($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'task_id' => null,
            'activity_type' => 'create',
            'description' => 'Membuat kategori baru: "' . $category->name . '"',
        ]);

        return redirect()->back()->with('success', 'Kategori baru berhasil dibuat!');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validated();
        $category->update($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'task_id' => null,
            'activity_type' => 'update',
            'description' => 'Memperbarui kategori: "' . $category->name . '"',
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Request $request, Category $category)
    {
        $this->authorize('delete', $category);

        $count = Task::where('category_id', $category->id)->count();
        // Unassign category from tasks safely
        Task::where('category_id', $category->id)->update(['category_id' => null]);

        $name = $category->name;
        $category->delete();

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'task_id' => null,
            'activity_type' => 'delete',
            'description' => 'Menghapus kategori: "' . $name . '" (tugas dialihkan: ' . $count . ')',
        ]);

        $message = $count > 0
            ? "Kategori \"{$name}\" dihapus. Sebanyak {$count} tugas dipindahkan ke Tanpa Kategori."
            : "Kategori \"{$name}\" berhasil dihapus.";

        return redirect()->back()->with('info', $message);
    }
}
