<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Display all submissions (all assignments)
     */
    public function index(Request $request)
    {
        $query = Submission::with(['assignment', 'asprak'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assignment
        if ($request->filled('assignment_id')) {
            $query->where('assignment_id', $request->assignment_id);
        }

        $submissions = $query->paginate(15);

        // Get assignments for filter dropdown
        $assignments = Assignment::orderBy('judul')->get();

        // Statistics
        $stats = [
            'total' => Submission::count(),
            'pending' => Submission::byStatus(Submission::STATUS_PENDING)->count(),
            'approved' => Submission::byStatus(Submission::STATUS_APPROVED)->count(),
            'rejected' => Submission::byStatus(Submission::STATUS_REJECTED)->count(),
        ];

        return view('laboran.submissions.index', compact('submissions', 'assignments', 'stats'));
    }

    /**
     * Display submissions for specific assignment
     */
    public function byAssignment(Assignment $assignment)
    {
        $submissions = Submission::with(['asprak'])
            ->where('assignment_id', $assignment->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('laboran.submissions.by-assignment', compact('assignment', 'submissions'));
    }

    /**
     * Display the specified submission
     */
    public function show(Submission $submission)
    {
        $submission->load(['assignment', 'asprak', 'reviewer']);

        return view('laboran.submissions.show', compact('submission'));
    }

    /**
     * Show approve form
     */
    public function approveForm(Submission $submission)
    {
        if ($submission->status !== Submission::STATUS_PENDING) {
            return redirect()
                ->route('laboran.submissions.show', $submission)
                ->with('error', 'Submission ini sudah direview sebelumnya.');
        }

        $submission->load(['assignment', 'asprak']);

        return view('laboran.submissions.approve', compact('submission'));
    }

    /**
     * Process approval
     */
    public function approve(Request $request, Submission $submission)
    {
        if ($submission->status !== Submission::STATUS_PENDING) {
            return redirect()
                ->route('laboran.submissions.show', $submission)
                ->with('error', 'Submission ini sudah direview sebelumnya.');
        }

        $validated = $request->validate([
            'feedback' => 'required|min:10',
        ], [
            'feedback.required' => 'Feedback wajib diisi.',
            'feedback.min' => 'Feedback minimal 10 karakter.',
        ]);

        $submission->update([
            'status' => Submission::STATUS_APPROVED,
            'feedback' => $validated['feedback'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('laboran.submissions.show', $submission)
            ->with('success', 'Submission berhasil disetujui!');
    }

    /**
     * Show reject form
     */
    public function rejectForm(Submission $submission)
    {
        if ($submission->status !== Submission::STATUS_PENDING) {
            return redirect()
                ->route('laboran.submissions.show', $submission)
                ->with('error', 'Submission ini sudah direview sebelumnya.');
        }

        $submission->load(['assignment', 'asprak']);

        return view('laboran.submissions.reject', compact('submission'));
    }

    /**
     * Process rejection
     */
    public function reject(Request $request, Submission $submission)
    {
        if ($submission->status !== Submission::STATUS_PENDING) {
            return redirect()
                ->route('laboran.submissions.show', $submission)
                ->with('error', 'Submission ini sudah direview sebelumnya.');
        }

        $validated = $request->validate([
            'feedback' => 'required|min:10',
        ], [
            'feedback.required' => 'Feedback wajib diisi.',
            'feedback.min' => 'Feedback minimal 10 karakter.',
        ]);

        $submission->update([
            'status' => Submission::STATUS_REJECTED,
            'feedback' => $validated['feedback'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('laboran.submissions.show', $submission)
            ->with('success', 'Submission berhasil ditolak. Asprak dapat melihat feedback Anda.');
    }
}
