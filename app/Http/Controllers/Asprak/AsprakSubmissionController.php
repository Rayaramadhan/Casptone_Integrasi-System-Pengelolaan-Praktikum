<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AsprakSubmissionController extends Controller
{
    /**
     * Display a listing of assignments and submissions
     */
    public function index(Request $request)
    {
        \Log::info('AsprakSubmissionController index called', [
            'tab' => $request->get('tab', 'available'),
            'user_id' => Auth::id(),
        ]);
        
        $tab = $request->get('tab', 'available');
        
        // Statistics
        $stats = [
            'total' => Assignment::where('status', 'active')->count(),
            'active' => Assignment::where('status', 'active')->count(),
            'submitted' => Submission::where('asprak_id', Auth::id())->count(),
            'pending' => Assignment::where('status', 'active')
                ->whereDoesntHave('submissions', function($query) {
                    $query->where('asprak_id', Auth::id());
                })->count(),
        ];

        if ($tab === 'available') {
            // Available Assignments
            $query = Assignment::where('status', 'active')
                ->with(['submissions' => function($query) {
                    $query->where('asprak_id', Auth::id());
                }]);

            // Filters
            if ($request->filled('tipe')) {
                $query->where('tipe', $request->tipe);
            }
            if ($request->filled('praktikum')) {
                $query->where('praktikum', 'like', '%' . $request->praktikum . '%');
            }

            $assignments = $query->orderBy('deadline', 'asc')->paginate(9);
            $mySubmissions = Submission::where('id', 0)->paginate(15); // Empty paginator
        } else {
            // My Submissions
            try {
                // Test query tanpa eager loading dulu
                $mySubmissions = Submission::where('asprak_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                
                // Load relationships setelah paginate
                $mySubmissions->load('assignment', 'reviewer');
                
                \Log::info('Query Success', [
                    'user_id' => Auth::id(),
                    'total' => $mySubmissions->total(),
                    'count' => $mySubmissions->count(),
                    'items' => $mySubmissions->items(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Query Failed', [
                    'user_id' => Auth::id(),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $mySubmissions = Submission::where('id', 0)->paginate(15);
            }
            
            $assignments = Assignment::where('id', 0)->paginate(9); // Empty paginator
        }

        // CRITICAL DEBUG - cek tipe data sebelum return
        \Log::info('Before return view', [
            'mySubmissions_type' => gettype($mySubmissions),
            'mySubmissions_class' => is_object($mySubmissions) ? get_class($mySubmissions) : 'not object',
            'mySubmissions_value' => is_object($mySubmissions) ? 'is object' : print_r($mySubmissions, true),
        ]);

        return view('asprak.submissions.index', compact('stats', 'assignments', 'mySubmissions'));
    }

    /**
     * Show the form for creating a new submission
     */
    public function create(Assignment $assignment)
    {
        // Check if already submitted
        $existingSubmission = Submission::where('assignment_id', $assignment->id)
            ->where('asprak_id', Auth::id())
            ->first();

        if ($existingSubmission) {
            return redirect()->route('asprak.submissions.show', $existingSubmission)
                ->with('error', 'Anda sudah submit untuk penugasan ini');
        }

        return view('asprak.submissions.create', compact('assignment'));
    }

    /**
     * Store a newly created submission in storage
     */
    public function store(Request $request, Assignment $assignment)
    {
        // Check if already submitted
        $existingSubmission = Submission::where('assignment_id', $assignment->id)
            ->where('asprak_id', Auth::id())
            ->first();

        if ($existingSubmission) {
            return redirect()->route('asprak.submissions.show', $existingSubmission)
                ->with('error', 'Anda sudah submit untuk penugasan ini');
        }

        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:10240', // 10MB
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Upload file
        $file = $request->file('file');
        $fileName = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('submissions', $fileName, 'public');

        // Create submission
        $submission = Submission::create([
            'assignment_id' => $assignment->id,
            'asprak_id' => Auth::id(),
            'file_path' => $filePath,
            'catatan' => $request->catatan,
            'status' => 'pending',
        ]);

        return redirect()->route('asprak.submissions.index', ['tab' => 'submissions'])
            ->with('success', 'Submission berhasil dikumpulkan!');
    }

    /**
     * Display the specified submission
     */
    public function show(Submission $submission)
    {
        // Check ownership
        if ($submission->asprak_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $submission->load(['assignment', 'reviewer']);

        return view('asprak.submissions.show', compact('submission'));
    }

    /**
     * Remove the specified submission from storage
     */
    public function destroy(Submission $submission)
    {
        // Check ownership
        if ($submission->asprak_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Only allow deletion if pending
        if ($submission->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya submission dengan status pending yang bisa dihapus');
        }

        // Delete file
        if (Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();

        return redirect()->route('asprak.submissions.index', ['tab' => 'submissions'])
            ->with('success', 'Submission berhasil dihapus');
    }
}
