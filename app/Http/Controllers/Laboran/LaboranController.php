<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\ResourceRequest;
use Illuminate\Http\Request;

class LaboranController extends Controller
{
    public function index(){
        // Get assignment statistics
        $assignmentStats = [
            'total' => Assignment::count(),
            'active' => Assignment::byStatus('active')->count(),
            'closed' => Assignment::byStatus('closed')->count(),
            'expired' => Assignment::where('deadline', '<', now())
                ->where('status', 'active')
                ->count(),
        ];

        // Get submission statistics
        $submissionStats = [
            'total' => Submission::count(),
            'pending' => Submission::byStatus('pending')->count(),
            'approved' => Submission::byStatus('approved')->count(),
            'rejected' => Submission::byStatus('rejected')->count(),
        ];

        // Get recent pending submissions (last 5)
        $recentPendingSubmissions = Submission::byStatus('pending')
            ->with(['asprak', 'assignment'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get expired assignments (deadline passed but still active)
        $expiredAssignments = Assignment::where('deadline', '<', now())
            ->where('status', 'active')
            ->with('creator')
            ->orderBy('deadline', 'asc')
            ->limit(5)
            ->get();

        // Get resource request statistics
        $resourceRequestStats = [
            'total' => ResourceRequest::count(),
            'pending' => ResourceRequest::pending()->count(),
            'approved' => ResourceRequest::approved()->count(),
            'rejected' => ResourceRequest::rejected()->count(),
            'overdue' => ResourceRequest::where('status', 'pending')
                ->where('needed_date', '<', now())
                ->count(),
        ];

        // Get pending resource requests (last 5)
        $pendingResourceRequests = ResourceRequest::pending()
            ->with('user')
            ->orderBy('needed_date', 'asc')
            ->limit(5)
            ->get();

        // Get overdue resource requests
        $overdueResourceRequests = ResourceRequest::pending()
            ->where('needed_date', '<', now())
            ->with('user')
            ->orderBy('needed_date', 'asc')
            ->limit(5)
            ->get();

        return view('laboran.dashboard', compact(
            'assignmentStats',
            'submissionStats', 
            'recentPendingSubmissions', 
            'expiredAssignments',
            'resourceRequestStats', 
            'pendingResourceRequests', 
            'overdueResourceRequests'
        ));
    }
}
