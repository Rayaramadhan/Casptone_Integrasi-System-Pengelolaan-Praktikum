<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ReportReviewController extends Controller
{
    /**
     * Display a listing of all reports for review.
     */
    public function index(Request $request)
    {
        $query = Report::with(['user', 'reviewer'])
                      ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by title or submitter name
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $reports = $query->paginate(15);

        // Calculate statistics
        $stats = [
            'total' => Report::count(),
            'pending' => Report::pending()->count(),
            'approved' => Report::approved()->count(),
            'revision' => Report::revisionRequested()->count(),
            'overdue' => Report::overdue()->count(),
        ];

        return view('laboran.reports.index', compact('reports', 'stats'));
    }

    /**
     * Show the review form for a specific report.
     */
    public function show(Report $report)
    {
        $report->load(['user', 'reviewer']);

        return view('laboran.reports.show', compact('report'));
    }

    /**
     * Download the report file for review.
     */
    public function download(Report $report)
    {
        if (!Storage::disk('private')->exists($report->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('private')->download(
            $report->file_path,
            $report->original_filename
        );
    }

    /**
     * Approve the report.
     */
    public function approve(Report $report)
    {
        // Only approve if status is pending
        if ($report->status !== 'pending') {
            return back()->with('error', 'Hanya laporan dengan status pending yang dapat disetujui.');
        }

        $report->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
            'revision_notes' => null,
        ]);

        return redirect()->route('laboran.reports.index')
                        ->with('success', 'Laporan berhasil disetujui!');
    }

    /**
     * Request revision for the report.
     */
    public function requestRevision(Request $request, Report $report)
    {
        $request->validate([
            'revision_notes' => 'required|string|min:10',
        ]);

        // Only request revision if status is pending
        if ($report->status !== 'pending') {
            return back()->with('error', 'Hanya laporan dengan status pending yang dapat diminta revisi.');
        }

        $report->update([
            'status' => 'revision_requested',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
            'revision_notes' => $request->revision_notes,
        ]);

        return redirect()->route('laboran.reports.index')
                        ->with('success', 'Permintaan revisi berhasil dikirim ke Asprak.');
    }

    /**
     * Show the revision request form.
     */
    public function revisionForm(Report $report)
    {
        // Only show form if status is pending
        if ($report->status !== 'pending') {
            return back()->with('error', 'Hanya laporan dengan status pending yang dapat diminta revisi.');
        }

        $report->load('user');

        return view('laboran.reports.revision', compact('report'));
    }
}
