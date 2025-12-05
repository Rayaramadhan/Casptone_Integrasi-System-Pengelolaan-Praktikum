<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\ResourceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceRequestController extends Controller
{
    /**
     * Display a listing of resource requests
     */
    public function index(Request $request)
    {
        $query = ResourceRequest::where('user_id', Auth::id())
            ->with(['reviewer']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by resource type
        if ($request->filled('resource_type')) {
            $query->where('resource_type', $request->resource_type);
        }

        // Filter by laboratorium
        if ($request->filled('laboratorium')) {
            $query->where('laboratorium', $request->laboratorium);
        }

        // Get statistics
        $stats = [
            'total' => ResourceRequest::where('user_id', Auth::id())->count(),
            'pending' => ResourceRequest::where('user_id', Auth::id())->pending()->count(),
            'approved' => ResourceRequest::where('user_id', Auth::id())->approved()->count(),
            'rejected' => ResourceRequest::where('user_id', Auth::id())->rejected()->count(),
        ];

        $requests = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('asprak.resource-requests.index', compact('requests', 'stats'));
    }

    /**
     * Show the form for creating a new resource request
     */
    public function create()
    {
        $laboratoriums = ResourceRequest::getLaboratoriums();
        $praktikums = [];
        
        foreach ($laboratoriums as $lab) {
            $praktikums[$lab] = ResourceRequest::getPraktikumsForLab($lab);
        }
        
        return view('asprak.resource-requests.create', compact('laboratoriums', 'praktikums'));
    }

    /**
     * Store a newly created resource request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'laboratorium' => 'required|in:EISD,ERP,EDM,EIM,SAG',
            'nama_praktikum' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'resource_type' => 'required|in:room,tool_account,hardware,software,other',
            'quantity' => 'required|integer|min:1',
            'needed_date' => 'required|date|after:today',
            'needed_time' => 'nullable|date_format:H:i',
            'duration' => 'nullable|integer|min:15',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        ResourceRequest::create($validated);

        return redirect()->route('asprak.resource-requests.index')
            ->with('success', 'Permintaan kebutuhan praktikum berhasil diajukan! Menunggu review dari Laboran.');
    }

    /**
     * Display the specified resource request
     */
    public function show(ResourceRequest $resourceRequest)
    {
        // Authorization: only owner can view
        if ($resourceRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $resourceRequest->load(['user', 'reviewer']);

        return view('asprak.resource-requests.show', compact('resourceRequest'));
    }

    /**
     * Remove the specified resource request
     */
    public function destroy(ResourceRequest $resourceRequest)
    {
        // Authorization: only owner can delete
        if ($resourceRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow deletion of pending requests
        if ($resourceRequest->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan dengan status "Pending" yang dapat dihapus!');
        }

        $resourceRequest->delete();

        return redirect()->route('asprak.resource-requests.index')
            ->with('success', 'Permintaan resource berhasil dihapus!');
    }

    /**
     * Show the form for resubmitting a rejected request
     */
    public function resubmit(ResourceRequest $resourceRequest)
    {
        // Authorization: only owner can resubmit
        if ($resourceRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow resubmission of rejected requests
        if ($resourceRequest->status !== 'rejected') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan yang ditolak yang dapat diajukan kembali!');
        }

        $laboratoriums = ResourceRequest::getLaboratoriums();
        $praktikums = [];
        
        foreach ($laboratoriums as $lab) {
            $praktikums[$lab] = ResourceRequest::getPraktikumsForLab($lab);
        }

        return view('asprak.resource-requests.resubmit', compact('resourceRequest', 'laboratoriums', 'praktikums'));
    }

    /**
     * Update and resubmit a rejected request
     */
    public function updateResubmit(Request $request, ResourceRequest $resourceRequest)
    {
        // Authorization: only owner can resubmit
        if ($resourceRequest->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow resubmission of rejected requests
        if ($resourceRequest->status !== 'rejected') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan yang ditolak yang dapat diajukan kembali!');
        }

        $validated = $request->validate([
            'laboratorium' => 'required|in:EISD,ERP,EDM,EIM,SAG',
            'nama_praktikum' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'resource_type' => 'required|in:room,tool_account,hardware,software,other',
            'quantity' => 'required|integer|min:1',
            'needed_date' => 'required|date|after:today',
            'needed_time' => 'nullable|date_format:H:i',
            'duration' => 'nullable|integer|min:15',
        ]);

        // Reset status and review info
        $validated['status'] = 'pending';
        $validated['feedback'] = null;
        $validated['reviewed_at'] = null;
        $validated['reviewed_by'] = null;

        $resourceRequest->update($validated);

        return redirect()->route('asprak.resource-requests.show', $resourceRequest)
            ->with('success', 'Permintaan berhasil diajukan kembali! Menunggu review dari Laboran.');
    }
}
