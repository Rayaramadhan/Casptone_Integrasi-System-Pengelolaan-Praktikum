<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports for the authenticated asprak.
     */
    public function index(Request $request)
    {
        $query = Report::where('user_id', Auth::id())
                      ->with('reviewer')
                      ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $reports = $query->paginate(10);

        // Calculate statistics
        $stats = [
            'total' => Report::where('user_id', Auth::id())->count(),
            'pending' => Report::where('user_id', Auth::id())->pending()->count(),
            'approved' => Report::where('user_id', Auth::id())->approved()->count(),
            'revision' => Report::where('user_id', Auth::id())->revisionRequested()->count(),
        ];

        return view('asprak.reports.index', compact('reports', 'stats'));
    }

    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        return view('asprak.reports.create');
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date|after_or_equal:today',
            'file' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240', // Max 10MB
        ]);

        // Store the file
        $file = $request->file('file');
        $originalFilename = $file->getClientOriginalName();
        $filename = time() . '_' . $originalFilename;
        $filePath = $file->storeAs('reports', $filename, 'private');

        // Create the report
        Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'file_path' => $filePath,
            'original_filename' => $originalFilename,
            'status' => 'pending',
        ]);

        return redirect()->route('asprak.reports.index')
                        ->with('success', 'Laporan berhasil disubmit! Menunggu review dari Laboran.');
    }

    /**
     * Display the specified report.
     */
    public function show(Report $report)
    {
        // Ensure the authenticated user owns this report
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $report->load('reviewer');

        return view('asprak.reports.show', compact('report'));
    }

    /**
     * Download the report file.
     */
    public function download(Report $report)
    {
        // Ensure the authenticated user owns this report
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('private')->exists($report->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('private')->download(
            $report->file_path,
            $report->original_filename
        );
    }

    /**
     * Remove the specified report from storage.
     */
    public function destroy(Report $report)
    {
        // Ensure the authenticated user owns this report
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow deletion if status is revision_requested or pending
        if (!in_array($report->status, ['pending', 'revision_requested'])) {
            return back()->with('error', 'Laporan yang sudah disetujui tidak dapat dihapus.');
        }

        // Delete the file
        if (Storage::disk('private')->exists($report->file_path)) {
            Storage::disk('private')->delete($report->file_path);
        }

        $report->delete();

        return redirect()->route('asprak.reports.index')
                        ->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Show the form for resubmitting a report (after revision request).
     */
    public function resubmit(Report $report)
    {
        // Ensure the authenticated user owns this report
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow resubmit if revision was requested
        if ($report->status !== 'revision_requested') {
            return back()->with('error', 'Hanya laporan yang diminta revisi yang dapat disubmit ulang.');
        }

        return view('asprak.reports.resubmit', compact('report'));
    }

    /**
     * Update the report with new file (resubmission).
     */
    public function updateResubmit(Request $request, Report $report)
    {
        // Ensure the authenticated user owns this report
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow resubmit if revision was requested
        if ($report->status !== 'revision_requested') {
            return back()->with('error', 'Hanya laporan yang diminta revisi yang dapat disubmit ulang.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240', // Max 10MB
        ]);

        // Delete old file
        if (Storage::disk('private')->exists($report->file_path)) {
            Storage::disk('private')->delete($report->file_path);
        }

        // Store the new file
        $file = $request->file('file');
        $originalFilename = $file->getClientOriginalName();
        $filename = time() . '_' . $originalFilename;
        $filePath = $file->storeAs('reports', $filename, 'private');

        // Update the report
        $report->update([
            'file_path' => $filePath,
            'original_filename' => $originalFilename,
            'status' => 'pending',
            'revision_notes' => null,
            'reviewed_at' => null,
            'reviewed_by' => null,
        ]);

        return redirect()->route('asprak.reports.index')
                        ->with('success', 'Laporan berhasil disubmit ulang! Menunggu review dari Laboran.');
    }
}
