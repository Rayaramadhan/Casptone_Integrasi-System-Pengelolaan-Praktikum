<?php

namespace App\Http\Controllers;

use App\Models\Backlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BacklogController extends Controller
{
    /**
     * Display a listing of the backlogs.
     */
    public function index(Request $request)
    {
        $query = Backlog::where('user_id', Auth::id());

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter berdasarkan assign_to
        if ($request->filled('assign_to')) {
            $query->byAssignTo($request->assign_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'deadline');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $backlogs = $query->paginate(10);

        // Hitung statistik
        $stats = [
            'total' => Backlog::where('user_id', Auth::id())->count(),
            'belum_dikerjakan' => Backlog::where('user_id', Auth::id())
                ->byStatus(Backlog::STATUS_BELUM_DIKERJAKAN)->count(),
            'on_progress' => Backlog::where('user_id', Auth::id())
                ->byStatus(Backlog::STATUS_ON_PROGRESS)->count(),
            'done' => Backlog::where('user_id', Auth::id())
                ->byStatus(Backlog::STATUS_DONE)->count(),
            'overdue' => Backlog::where('user_id', Auth::id())->overdue()->count(),
        ];

        return view('asprak.backlogs.index', compact('backlogs', 'stats'));
    }

    /**
     * Show the form for creating a new backlog.
     */
    public function create()
    {
        return view('asprak.backlogs.create');
    }

    /**
     * Store a newly created backlog in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'assign_to' => 'nullable|string|max:255',
            'progress_notes' => 'nullable|string',
            'progress_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('progress_file')) {
            $validated['progress_file'] = $request->file('progress_file')
                ->store('backlogs/progress-files', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = Backlog::STATUS_BELUM_DIKERJAKAN;

        Backlog::create($validated);

        return redirect()->route('asprak.backlogs.index')
            ->with('success', 'Backlog berhasil ditambahkan!');
    }

    /**
     * Display the specified backlog.
     */
    public function show(Backlog $backlog)
    {
        // Pastikan backlog milik user yang sedang login
        if ($backlog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('asprak.backlogs.show', compact('backlog'));
    }

    /**
     * Show the form for editing the specified backlog.
     */
    public function edit(Backlog $backlog)
    {
        // Pastikan backlog milik user yang sedang login
        if ($backlog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('asprak.backlogs.edit', compact('backlog'));
    }

    /**
     * Update the specified backlog in storage.
     */
    public function update(Request $request, Backlog $backlog)
    {
        // Pastikan backlog milik user yang sedang login
        if ($backlog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|in:belum_dikerjakan,on_progress,done',
            'assign_to' => 'nullable|string|max:255',
            'progress_notes' => 'nullable|string',
            'progress_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('progress_file')) {
            // Delete old file if exists
            $backlog->deleteProgressFile();
            
            $validated['progress_file'] = $request->file('progress_file')
                ->store('backlogs/progress-files', 'public');
        }

        $backlog->update($validated);

        return redirect()->route('asprak.backlogs.index')
            ->with('success', 'Backlog berhasil diperbarui!');
    }

    /**
     * Update backlog status.
     */
    public function updateStatus(Request $request, Backlog $backlog)
    {
        // Pastikan backlog milik user yang sedang login
        if ($backlog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:belum_dikerjakan,on_progress,done',
        ]);

        $backlog->update($validated);

        return redirect()->back()
            ->with('success', 'Status backlog berhasil diperbarui!');
    }

    /**
     * Remove the specified backlog from storage.
     */
    public function destroy(Backlog $backlog)
    {
        // Pastikan backlog milik user yang sedang login
        if ($backlog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete progress file if exists
        $backlog->deleteProgressFile();

        $backlog->delete();

        return redirect()->route('asprak.backlogs.index')
            ->with('success', 'Backlog berhasil dihapus!');
    }
}
