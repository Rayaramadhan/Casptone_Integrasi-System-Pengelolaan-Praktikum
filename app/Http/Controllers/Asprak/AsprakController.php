<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\Backlog;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\ResourceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsprakController extends Controller
{
    public function index(){
        // Get backlog statistics for the logged-in asprak
        $taskStats = [
            'total' => Backlog::where('user_id', Auth::id())->count(),
            'belum_dikerjakan' => Backlog::where('user_id', Auth::id())
                ->byStatus(Backlog::STATUS_BELUM_DIKERJAKAN)->count(),
            'on_progress' => Backlog::where('user_id', Auth::id())
                ->byStatus(Backlog::STATUS_ON_PROGRESS)->count(),
            'done' => Backlog::where('user_id', Auth::id())
                ->byStatus(Backlog::STATUS_DONE)->count(),
            'overdue' => Backlog::where('user_id', Auth::id())->overdue()->count(),
        ];

        // Get upcoming backlogs (next 7 days, not done)
        $upcomingTasks = Backlog::where('user_id', Auth::id())
            ->where('status', '!=', Backlog::STATUS_DONE)
            ->where('deadline', '>=', now())
            ->where('deadline', '<=', now()->addDays(7))
            ->orderBy('deadline', 'asc')
            ->limit(5)
            ->get();

        // Get assignment & submission statistics for the logged-in asprak
        $assignmentStats = [
            'total' => Assignment::where('status', 'active')->count(),
            'submitted' => Submission::where('asprak_id', Auth::id())->count(),
            'pending' => Submission::where('asprak_id', Auth::id())->where('status', 'pending')->count(),
            'approved' => Submission::where('asprak_id', Auth::id())->where('status', 'approved')->count(),
        ];

        // Get recent submissions (last 5)
        $recentSubmissions = Submission::where('asprak_id', Auth::id())
            ->with(['assignment'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get resource request statistics for the logged-in asprak
        $resourceRequestStats = [
            'total' => ResourceRequest::where('user_id', Auth::id())->count(),
            'pending' => ResourceRequest::where('user_id', Auth::id())->pending()->count(),
            'approved' => ResourceRequest::where('user_id', Auth::id())->approved()->count(),
            'rejected' => ResourceRequest::where('user_id', Auth::id())->rejected()->count(),
        ];

        // Get recent resource requests (last 5)
        $recentResourceRequests = ResourceRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('asprak.dashboard', compact('taskStats', 'upcomingTasks', 'assignmentStats', 'recentSubmissions', 'resourceRequestStats', 'recentResourceRequests'));
    }
}