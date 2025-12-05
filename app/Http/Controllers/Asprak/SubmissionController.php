<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Display assignments available for asprak
     * TODO: Filter by praktikum when asprak table has praktikum field
     */
    public function index(Request $request)
    {
        $query = Assignment::with(['creator', 'submissions'])
            ->orderBy('deadline', 'asc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by tipe
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $assignments = $query->paginate(10);

        // Get asprak's submissions with full data (not just IDs)
        $mySubmissions = Submission::with(['assignment', 'reviewer'])
            ->where('asprak_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get assignment IDs that asprak already submitted (for checking)
        $submittedAssignmentIds = Submission::where('asprak_id', Auth::id())
            ->pluck('assignment_id')
            ->toArray();

        // Count untuk statistik
        $totalActiveAssignments = Assignment::where('status', Assignment::STATUS_ACTIVE)->count();
        $totalMySubmissions = Submission::where('asprak_id', Auth::id())->count();
        $totalPendingReview = Submission::where('asprak_id', Auth::id())
            ->where('status', Submission::STATUS_PENDING)
            ->count();
        $totalNotSubmittedYet = Assignment::where('status', Assignment::STATUS_ACTIVE)
            ->whereDoesntHave('submissions', function($query) {
                $query->where('asprak_id', Auth::id());
            })
            ->count();

        // Statistics - sesuai dengan label di view
        $stats = [
            'total' => $totalActiveAssignments,           // Total Penugasan Aktif
            'active' => $totalNotSubmittedYet,            // Belum Dikumpulkan (hijau)
            'submitted' => $totalMySubmissions,           // Sudah Dikumpulkan (biru)
            'pending' => $totalPendingReview,             // Pending Review (kuning)
        ];

        return view('asprak.submissions.index', compact('assignments', 'mySubmissions', 'submittedAssignmentIds', 'stats'));
    }

    /**
     * Display my submissions (Redirect to index with submissions tab)
     */
    public function mySubmissions(Request $request)
    {
        return redirect()->route('asprak.submissions.index', ['tab' => 'submissions']);
    }

    /**
     * Show assignment detail
     */
    public function showAssignment(Assignment $assignment)
    {
        $assignment->load(['creator']);

        // Check if asprak already submitted
        $mySubmission = Submission::where('assignment_id', $assignment->id)
            ->where('asprak_id', Auth::id())
            ->first();

        return view('asprak.submissions.show-assignment', compact('assignment', 'mySubmission'));
    }

    /**
     * Show create submission form
     */
    public function create(Assignment $assignment)
    {
        // Check if assignment is active
        if ($assignment->status !== Assignment::STATUS_ACTIVE) {
            return redirect()
                ->route('asprak.submissions.show-assignment', $assignment)
                ->with('error', 'Penugasan ini sudah ditutup. Tidak dapat mengumpulkan lagi.');
        }

        // Check if deadline passed
        if ($assignment->is_expired) {
            return redirect()
                ->route('asprak.submissions.show-assignment', $assignment)
                ->with('error', 'Deadline sudah lewat. Tidak dapat mengumpulkan lagi.');
        }

        // Check if already submitted
        $exists = Submission::where('assignment_id', $assignment->id)
            ->where('asprak_id', Auth::id())
            ->exists();

        if ($exists) {
            return redirect()
                ->route('asprak.submissions.show-assignment', $assignment)
                ->with('error', 'Anda sudah mengumpulkan untuk penugasan ini.');
        }

        return view('asprak.submissions.create', compact('assignment'));
    }

    /**
     * Store submission
     */
    public function store(Request $request, Assignment $assignment)
    {
        // Validation checks
        if ($assignment->status !== Assignment::STATUS_ACTIVE) {
            return back()->with('error', 'Penugasan ini sudah ditutup.');
        }

        if ($assignment->is_expired) {
            return back()->with('error', 'Deadline sudah lewat.');
        }

        $exists = Submission::where('assignment_id', $assignment->id)
            ->where('asprak_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah mengumpulkan untuk penugasan ini.');
        }

        // Validate
        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:20480', // 20MB
            'catatan' => 'nullable|max:1000',
        ], [
            'file.required' => 'File submission wajib diupload.',
            'file.mimes' => 'File harus berupa: PDF, DOC, DOCX, XLS, XLSX, atau ZIP.',
            'file.max' => 'Ukuran file maksimal 20MB.',
        ]);

        // Upload file
        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('submissions', $fileName, 'public');

        // Create submission
        Submission::create([
            'assignment_id' => $assignment->id,
            'asprak_id' => Auth::id(),
            'file_path' => $filePath,
            'catatan' => $request->catatan,
            'status' => Submission::STATUS_PENDING,
        ]);

        return redirect()
            ->route('asprak.submissions.index', ['tab' => 'submissions'])
            ->with('success', 'Submission berhasil dikumpulkan! Menunggu review dari Laboran.');
    }

    /**
     * Show edit submission form (only if pending)
     */
    public function edit(Submission $submission)
    {
        // Authorization: only owner can edit
        if ($submission->asprak_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke submission ini.');
        }

        // Only pending submissions can be edited
        if ($submission->status !== Submission::STATUS_PENDING) {
            return redirect()
                ->route('asprak.submissions.show', $submission)
                ->with('error', 'Hanya submission yang masih pending yang dapat diedit.');
        }

        // Check if assignment is still active
        $assignment = $submission->assignment;
        if ($assignment->status !== Assignment::STATUS_ACTIVE) {
            return redirect()
                ->route('asprak.submissions.show', $submission)
                ->with('error', 'Penugasan sudah ditutup. Tidak dapat mengedit submission.');
        }

        // Check if deadline passed
        if ($assignment->is_expired) {
            return redirect()
                ->route('asprak.submissions.show', $submission)
                ->with('error', 'Deadline sudah lewat. Tidak dapat mengedit submission.');
        }

        $submission->load('assignment');

        return view('asprak.submissions.edit', compact('submission'));
    }

    /**
     * Update submission (only if pending)
     */
    public function update(Request $request, Submission $submission)
    {
        // Authorization: only owner can update
        if ($submission->asprak_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke submission ini.');
        }

        // Only pending submissions can be updated
        if ($submission->status !== Submission::STATUS_PENDING) {
            return redirect()
                ->route('asprak.submissions.show', $submission)
                ->with('error', 'Hanya submission yang masih pending yang dapat diedit.');
        }

        // Check if assignment is still active
        $assignment = $submission->assignment;
        if ($assignment->status !== Assignment::STATUS_ACTIVE) {
            return redirect()
                ->route('asprak.submissions.show', $submission)
                ->with('error', 'Penugasan sudah ditutup. Tidak dapat mengedit submission.');
        }

        // Check if deadline passed
        if ($assignment->is_expired) {
            return redirect()
                ->route('asprak.submissions.show', $submission)
                ->with('error', 'Deadline sudah lewat. Tidak dapat mengedit submission.');
        }

        // Validation
        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:20480',
            'catatan' => 'nullable|string|max:500',
        ], [
            'file.mimes' => 'File harus berformat: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, atau RAR.',
            'file.max' => 'Ukuran file maksimal 20MB.',
        ]);

        // Update file if uploaded
        if ($request->hasFile('file')) {
            // Delete old file
            if ($submission->file_path && \Storage::disk('public')->exists($submission->file_path)) {
                \Storage::disk('public')->delete($submission->file_path);
            }

            // Upload new file
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('submissions', $fileName, 'public');
            
            $submission->file_path = $filePath;
        }

        // Update catatan
        $submission->catatan = $request->catatan;
        $submission->save();

        return redirect()
            ->route('asprak.submissions.show', $submission)
            ->with('success', 'Submission berhasil diperbarui!');
    }

    /**
     * Show submission detail
     */
    public function show(Submission $submission)
    {
        // Authorization: only owner can view
        if ($submission->asprak_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke submission ini.');
        }

        $submission->load(['assignment', 'reviewer']);

        return view('asprak.submissions.show', compact('submission'));
    }

    /**
     * Delete submission (only if pending)
     */
    public function destroy(Submission $submission)
    {
        // Authorization
        if ($submission->asprak_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke submission ini.');
        }

        // Only pending can be deleted
        if ($submission->status !== Submission::STATUS_PENDING) {
            return back()->with('error', 'Hanya submission yang masih pending yang dapat dihapus.');
        }

        $submission->delete();

        return redirect()
            ->route('asprak.submissions.index', ['tab' => 'submissions'])
            ->with('success', 'Submission berhasil dihapus.');
    }
}
