<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan priority
        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }

        // Filter berdasarkan category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'deadline');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $tasks = $query->paginate(10);

        // Hitung statistik
        $stats = [
            'total' => Task::where('user_id', Auth::id())->count(),
            'pending' => Task::where('user_id', Auth::id())->pending()->count(),
            'in_progress' => Task::where('user_id', Auth::id())->inProgress()->count(),
            'completed' => Task::where('user_id', Auth::id())->completed()->count(),
            'overdue' => Task::where('user_id', Auth::id())
                ->where('deadline', '<', now())
                ->where('status', '!=', 'completed')
                ->count(),
        ];

        return view('asprak.tasks.index', compact('tasks', 'stats'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('asprak.tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
            'category' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Task::create($validated);

        return redirect()->route('asprak.tasks.index')
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        // Pastikan task milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('asprak.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        // Pastikan task milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('asprak.tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Pastikan task milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'category' => 'nullable|string|max:255',
        ]);

        $task->update($validated);

        return redirect()->route('asprak.tasks.index')
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Update task status.
     */
    public function updateStatus(Request $request, Task $task)
    {
        // Pastikan task milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($validated);

        return back()->with('success', 'Status tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        // Pastikan task milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();

        return redirect()->route('asprak.tasks.index')
            ->with('success', 'Tugas berhasil dihapus!');
    }
}
