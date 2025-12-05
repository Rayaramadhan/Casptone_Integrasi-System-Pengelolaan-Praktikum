<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of assignments
     */
    public function index(Request $request)
    {
        $query = Assignment::with(['creator', 'submissions'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by tipe
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Filter by praktikum
        if ($request->filled('praktikum')) {
            $query->where('praktikum', 'like', '%' . $request->praktikum . '%');
        }

        $assignments = $query->paginate(10);

        // Statistics
        $stats = [
            'total' => Assignment::count(),
            'active' => Assignment::byStatus(Assignment::STATUS_ACTIVE)->count(),
            'closed' => Assignment::byStatus(Assignment::STATUS_CLOSED)->count(),
            'pending_submissions' => \App\Models\Submission::byStatus('pending')->count(),
        ];

        return view('laboran.assignments.index', compact('assignments', 'stats'));
    }

    /**
     * Show the form for creating a new assignment
     */
    public function create()
    {
        return view('laboran.assignments.create');
    }

    /**
     * Store a newly created assignment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'tipe' => 'required|in:LPJ,RAB,Laporan,Proposal,Lainnya',
            'praktikum' => 'required|max:255',
            'deadline' => 'required|date|after:now',
        ], [
            'judul.required' => 'Judul penugasan wajib diisi.',
            'deskripsi.required' => 'Deskripsi penugasan wajib diisi.',
            'tipe.required' => 'Tipe penugasan wajib dipilih.',
            'tipe.in' => 'Tipe penugasan tidak valid.',
            'praktikum.required' => 'Nama praktikum wajib diisi.',
            'deadline.required' => 'Deadline wajib diisi.',
            'deadline.after' => 'Deadline harus setelah waktu sekarang.',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = Assignment::STATUS_ACTIVE;

        Assignment::create($validated);

        return redirect()
            ->route('laboran.assignments.index')
            ->with('success', 'Penugasan berhasil dibuat! Asprak di praktikum ' . $validated['praktikum'] . ' dapat melihat dan mengumpulkan tugas ini.');
    }

    /**
     * Display the specified assignment
     */
    public function show(Assignment $assignment)
    {
        $assignment->load(['creator', 'submissions.asprak']);

        return view('laboran.assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing the assignment
     */
    public function edit(Assignment $assignment)
    {
        return view('laboran.assignments.edit', compact('assignment'));
    }

    /**
     * Update the specified assignment
     */
    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'tipe' => 'required|in:LPJ,RAB,Laporan,Proposal,Lainnya',
            'praktikum' => 'required|max:255',
            'deadline' => 'required|date',
            'status' => 'required|in:active,closed',
        ], [
            'judul.required' => 'Judul penugasan wajib diisi.',
            'deskripsi.required' => 'Deskripsi penugasan wajib diisi.',
            'tipe.required' => 'Tipe penugasan wajib dipilih.',
            'praktikum.required' => 'Nama praktikum wajib diisi.',
            'deadline.required' => 'Deadline wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $assignment->update($validated);

        return redirect()
            ->route('laboran.assignments.show', $assignment)
            ->with('success', 'Penugasan berhasil diperbarui!');
    }

    /**
     * Remove the specified assignment
     */
    public function destroy(Assignment $assignment)
    {
        // Hapus assignment beserta semua submissions-nya (cascade)
        $assignment->delete();

        return redirect()
            ->route('laboran.assignments.index')
            ->with('success', 'Penugasan berhasil dihapus!');
    }

    /**
     * Close assignment (tidak bisa submit lagi)
     */
    public function close(Assignment $assignment)
    {
        if ($assignment->status === Assignment::STATUS_CLOSED) {
            return back()->with('error', 'Penugasan sudah ditutup sebelumnya.');
        }

        $assignment->update(['status' => Assignment::STATUS_CLOSED]);

        return back()->with('success', 'Penugasan berhasil ditutup. Asprak tidak dapat mengumpulkan lagi.');
    }

    /**
     * Reopen assignment
     */
    public function reopen(Assignment $assignment)
    {
        if ($assignment->status === Assignment::STATUS_ACTIVE) {
            return back()->with('error', 'Penugasan sudah aktif.');
        }

        $assignment->update(['status' => Assignment::STATUS_ACTIVE]);

        return back()->with('success', 'Penugasan berhasil dibuka kembali. Asprak dapat mengumpulkan lagi.');
    }
}
