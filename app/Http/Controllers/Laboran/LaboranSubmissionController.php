<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaboranSubmissionController extends Controller
{
    /**
     * Display a listing of submissions
     */
    public function index(Request $request)
    {
        $query = Submission::with(['asprak', 'assignment'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assignment
        if ($request->filled('assignment')) {
            $query->where('assignment_id', $request->assignment);
        }

        $submissions = $query->paginate(15);

        // Statistics
        $stats = [
            'total' => Submission::count(),
            'pending' => Submission::where('status', 'pending')->count(),
            'approved' => Submission::where('status', 'approved')->count(),
            'rejected' => Submission::where('status', 'rejected')->count(),
        ];

        // Get all assignments for filter dropdown
        $assignments = Assignment::orderBy('judul')->get();

        return view('laboran.submissions.index', compact('submissions', 'stats', 'assignments'));
    }

    /**
     * Display the specified submission
     */
    public function show(Submission $submission)
    {
        $submission->load(['asprak', 'assignment', 'reviewer']);
        return view('laboran.submissions.show', compact('submission'));
    }

    /**
     * Show the form for approving submission
     */
    public function approveForm(Submission $submission)
    {
        if ($submission->status !== 'pending') {
            return redirect()->route('laboran.submissions.show', $submission)
                ->with('error', 'Submission sudah direview');
        }

        return view('laboran.submissions.approve', compact('submission'));
    }

    /**
     * Approve the submission
     */
    public function approve(Request $request, Submission $submission)
    {
        if ($submission->status !== 'pending') {
            return redirect()->route('laboran.submissions.show', $submission)
                ->with('error', 'Submission sudah direview');
        }

        $validated = $request->validate([
            'feedback' => 'required|string|min:10|max:1000',
        ]);

        $submission->update([
            'status' => 'approved',
            'feedback' => $request->feedback,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('laboran.submissions.index')
            ->with('success', 'Submission berhasil diapprove!');
    }

    /**
     * Show the form for rejecting submission
     */
    public function rejectForm(Submission $submission)
    {
        if ($submission->status !== 'pending') {
            return redirect()->route('laboran.submissions.show', $submission)
                ->with('error', 'Submission sudah direview');
        }

        return view('laboran.submissions.reject', compact('submission'));
    }

    /**
     * Reject the submission
     */
    public function reject(Request $request, Submission $submission)
    {
        if ($submission->status !== 'pending') {
            return redirect()->route('laboran.submissions.show', $submission)
                ->with('error', 'Submission sudah direview');
        }

        $validated = $request->validate([
            'feedback' => 'required|string|min:20|max:1000',
        ]);

        $submission->update([
            'status' => 'rejected',
            'feedback' => $request->feedback,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('laboran.submissions.index')
            ->with('success', 'Submission ditolak. Asprak akan menerima notifikasi.');
    }

    /**
     * Get submissions by assignment
     */
    public function byAssignment(Assignment $assignment)
    {
        $submissions = Submission::where('assignment_id', $assignment->id)
            ->with(['asprak'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $submissions->count(),
            'pending' => $submissions->where('status', 'pending')->count(),
            'approved' => $submissions->where('status', 'approved')->count(),
            'rejected' => $submissions->where('status', 'rejected')->count(),
        ];

        return view('laboran.submissions.by-assignment', compact('assignment', 'submissions', 'stats'));
    }
}
