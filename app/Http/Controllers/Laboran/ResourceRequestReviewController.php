<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\ResourceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceRequestReviewController extends Controller
{
    /**
     * Display a listing of all resource requests for review
     */
    public function index(Request $request)
    {
        $query = ResourceRequest::with(['user']);

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

        // Filter overdue
        if ($request->filled('overdue') && $request->overdue == '1') {
            $query->overdue();
        }

        // Get statistics
        $stats = [
            'total' => ResourceRequest::count(),
            'pending' => ResourceRequest::pending()->count(),
            'approved' => ResourceRequest::approved()->count(),
            'rejected' => ResourceRequest::rejected()->count(),
            'overdue' => ResourceRequest::overdue()->count(),
        ];

        $requests = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('laboran.resource-requests.index', compact('requests', 'stats'))
            ->with('statistics', $stats);
    }

    /**
     * Display the specified resource request for review
     */
    public function show(ResourceRequest $resourceRequest)
    {
        $resourceRequest->load(['user', 'reviewer']);

        return view('laboran.resource-requests.show', compact('resourceRequest'));
    }

    /**
     * Show the form for approving a request
     */
    public function approveForm(ResourceRequest $resourceRequest)
    {
        // Only pending requests can be approved
        if ($resourceRequest->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan dengan status "Pending" yang dapat disetujui!');
        }

        return view('laboran.resource-requests.approve', compact('resourceRequest'));
    }

    /**
     * Approve a resource request
     */
    public function approve(Request $request, ResourceRequest $resourceRequest)
    {
        // Only pending requests can be approved
        if ($resourceRequest->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan dengan status "Pending" yang dapat disetujui!');
        }

        // Validate feedback (WAJIB)
        $validated = $request->validate([
            'feedback' => 'required|string|min:10',
        ], [
            'feedback.required' => 'Feedback wajib diisi untuk memberikan kejelasan kepada Asisten!',
            'feedback.min' => 'Feedback minimal 10 karakter.',
        ]);

        $resourceRequest->update([
            'status' => 'approved',
            'feedback' => $validated['feedback'],
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        return redirect()->route('laboran.resource-requests.show', $resourceRequest)
            ->with('success', 'Permintaan berhasil disetujui! Asisten akan menerima notifikasi.');
    }

    /**
     * Show the form for rejecting a request
     */
    public function rejectForm(ResourceRequest $resourceRequest)
    {
        // Only pending requests can be rejected
        if ($resourceRequest->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan dengan status "Pending" yang dapat ditolak!');
        }

        return view('laboran.resource-requests.reject', compact('resourceRequest'));
    }

    /**
     * Reject a resource request
     */
    public function reject(Request $request, ResourceRequest $resourceRequest)
    {
        // Only pending requests can be rejected
        if ($resourceRequest->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya permintaan dengan status "Pending" yang dapat ditolak!');
        }

        // Validate feedback (WAJIB)
        $validated = $request->validate([
            'feedback' => 'required|string|min:20',
        ], [
            'feedback.required' => 'Alasan penolakan wajib diisi untuk memberikan kejelasan kepada Asisten!',
            'feedback.min' => 'Alasan penolakan minimal 20 karakter agar Asisten memahami dengan jelas.',
        ]);

        $resourceRequest->update([
            'status' => 'rejected',
            'feedback' => $validated['feedback'],
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        return redirect()->route('laboran.resource-requests.show', $resourceRequest)
            ->with('success', 'Permintaan berhasil ditolak! Asisten akan menerima notifikasi beserta alasan penolakan.');
    }
}
