<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Laboran\LaboranController;
use App\Http\Controllers\Asprak\AsprakController;
use App\Http\Controllers\Dosen\DosenController;
use App\Http\Controllers\Asprak\NilaiController;
use App\Http\Controllers\Asprak\PresensiController;
use App\Http\Controllers\Asprak\ShiftExchangeController;
use App\Http\Controllers\Praktikan\PraktikanController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BacklogController;

// 👉 TAMBAHAN: controller salary
use App\Http\Controllers\Laboran\SalaryController as LaboranSalaryController;
use App\Http\Controllers\Asprak\SalaryController as AsprakSalaryController;

// 👉 TAMBAHAN: controller report (submission & approval)
use App\Http\Controllers\Asprak\ReportController;
use App\Http\Controllers\Laboran\ReportReviewController;

// 👉 TAMBAHAN: controller resource request (submission & approval)
use App\Http\Controllers\Asprak\ResourceRequestController;
use App\Http\Controllers\Laboran\ResourceRequestReviewController;

// 👉 TAMBAHAN: controller assignments & submissions (penugasan)
use App\Http\Controllers\Laboran\AssignmentController;
use App\Http\Controllers\Laboran\SubmissionController as LaboranSubmissionController;
use App\Http\Controllers\Asprak\SubmissionController as AsprakSubmissionController;

// ===============================
// 🌐 PUBLIC ROUTES
// ===============================
Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// ===============================
// 🔐 AUTH ROUTES
// ===============================
// aman dipakai di mana pun file ini berada
require base_path('routes/auth.php');

// ===============================
// 🔁 GLOBAL DASHBOARD REDIRECT
// ===============================
// Sekarang 4 role: laboran, dosen, praktikan, asprak (default)
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (! $user) {
        return redirect()->route('login');
    }

    switch ($user->usertype) {
        case 'laboran':
            return redirect()->route('laboran.dashboard');
        case 'dosen':
            return redirect()->route('dosen.dashboard');
        case 'praktikan':
            return redirect()->route('praktikan.dashboard');
        default:
            return redirect()->route('asprak.dashboard');
    }
})->middleware('auth')->name('dashboard');

// ===============================
// 👤 PROFILE (Authenticated)
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===============================
// 🧑‍🏫 LABORAN ROUTES
// ===============================
Route::middleware(['auth', 'laboranMiddleware'])->group(function () {
    Route::get('/laboran/dashboard', [LaboranController::class, 'index'])
        ->name('laboran.dashboard');

    // 👉 SALARY – POV LABORAN
    Route::get('/laboran/salary',        [LaboranSalaryController::class, 'index'])->name('laboran.salary.index');
    Route::get('/laboran/salary/create', [LaboranSalaryController::class, 'create'])->name('laboran.salary.create');
    Route::post('/laboran/salary',       [LaboranSalaryController::class, 'store'])->name('laboran.salary.store');

    // 👉 REPORT REVIEW – POV LABORAN (Review & Approve Reports)
    Route::get('/laboran/reports', [ReportReviewController::class, 'index'])
        ->name('laboran.reports.index');
    Route::get('/laboran/reports/{report}', [ReportReviewController::class, 'show'])
        ->name('laboran.reports.show');
    Route::get('/laboran/reports/{report}/download', [ReportReviewController::class, 'download'])
        ->name('laboran.reports.download');
    Route::post('/laboran/reports/{report}/approve', [ReportReviewController::class, 'approve'])
        ->name('laboran.reports.approve');
    Route::get('/laboran/reports/{report}/revision', [ReportReviewController::class, 'revisionForm'])
        ->name('laboran.reports.revisionForm');
    Route::post('/laboran/reports/{report}/revision', [ReportReviewController::class, 'requestRevision'])
        ->name('laboran.reports.requestRevision');

    // 👉 RESOURCE REQUEST REVIEW – POV LABORAN (Review & Approve/Reject Requests)
    Route::get('/laboran/resource-requests', [ResourceRequestReviewController::class, 'index'])
        ->name('laboran.resource-requests.index');
    Route::get('/laboran/resource-requests/{resourceRequest}', [ResourceRequestReviewController::class, 'show'])
        ->name('laboran.resource-requests.show');
    Route::get('/laboran/resource-requests/{resourceRequest}/approve', [ResourceRequestReviewController::class, 'approveForm'])
        ->name('laboran.resource-requests.approveForm');
    Route::post('/laboran/resource-requests/{resourceRequest}/approve', [ResourceRequestReviewController::class, 'approve'])
        ->name('laboran.resource-requests.approve');
    Route::get('/laboran/resource-requests/{resourceRequest}/reject', [ResourceRequestReviewController::class, 'rejectForm'])
        ->name('laboran.resource-requests.rejectForm');
    Route::post('/laboran/resource-requests/{resourceRequest}/reject', [ResourceRequestReviewController::class, 'reject'])
        ->name('laboran.resource-requests.reject');

    // 👉 ASSIGNMENTS – POV LABORAN (Create & Manage Penugasan)
    Route::resource('assignments', AssignmentController::class)->names('laboran.assignments');
    Route::post('/assignments/{assignment}/close', [AssignmentController::class, 'close'])
        ->name('laboran.assignments.close');
    Route::post('/assignments/{assignment}/reopen', [AssignmentController::class, 'reopen'])
        ->name('laboran.assignments.reopen');
    
    // 👉 SUBMISSIONS REVIEW – POV LABORAN (Review Submissions)
    Route::get('/submissions', [LaboranSubmissionController::class, 'index'])
        ->name('laboran.submissions.index');
    Route::get('/submissions/{submission}', [LaboranSubmissionController::class, 'show'])
        ->name('laboran.submissions.show');
    Route::get('/submissions/{submission}/approve', [LaboranSubmissionController::class, 'approveForm'])
        ->name('laboran.submissions.approveForm');
    Route::post('/submissions/{submission}/approve', [LaboranSubmissionController::class, 'approve'])
        ->name('laboran.submissions.approve');
    Route::get('/submissions/{submission}/reject', [LaboranSubmissionController::class, 'rejectForm'])
        ->name('laboran.submissions.rejectForm');
    Route::post('/submissions/{submission}/reject', [LaboranSubmissionController::class, 'reject'])
        ->name('laboran.submissions.reject');
    Route::get('/assignments/{assignment}/submissions', [LaboranSubmissionController::class, 'byAssignment'])
        ->name('laboran.submissions.by-assignment');
});

// ===============================
// 👨‍🏫 DOSEN ROUTES
// ===============================
Route::middleware(['auth', 'dosenMiddleware'])->group(function () {
    Route::get('/dosen/dashboard', [DosenController::class, 'index'])
        ->name('dosen.dashboard');
});

// ===============================
// 🧑‍🎓 PRAKTIKAN ROUTES
// ===============================
Route::middleware(['auth', 'praktikanMiddleware'])->group(function () {
    Route::get('/praktikan/dashboard', [PraktikanController::class, 'index'])
        ->name('praktikan.dashboard');
});

// ===============================
// 👨‍💻 ASPRAK & FITUR TERKAIT
// ===============================
// user biasa cukup pakai middleware 'auth'
Route::middleware(['auth'])->group(function () {
    // DASHBOARD ASPRAK
    Route::get('/asprak/dashboard', [AsprakController::class, 'index'])
        ->name('asprak.dashboard');

    // NILAI
    Route::get('/asprak/nilai', [NilaiController::class, 'index'])
        ->name('asprak.nilai.index');
    Route::post('/asprak/nilai', [NilaiController::class, 'store'])
        ->name('asprak.nilai.store');

    // PRESENSI
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi');
    Route::post('/presensi/checkin', [PresensiController::class, 'checkin'])
        ->name('presensi.checkin');
    Route::post('/presensi/checkout', [PresensiController::class, 'checkout'])
        ->name('presensi.checkout');

    // TUKAR SHIFT
    Route::get('/tukar-shift', [ShiftExchangeController::class, 'index'])->name('tukar_shift');
    Route::get('/request-shift', [ShiftExchangeController::class, 'create'])->name('request-shift.create');
    Route::post('/request-shift', [ShiftExchangeController::class, 'store'])->name('request-shift.store');
    Route::post('/shift-exchange/accept', [ShiftExchangeController::class, 'accept'])
        ->name('shift-exchange.accept');
    Route::post('/shift-exchange/reject', [ShiftExchangeController::class, 'reject'])
        ->name('shift-exchange.reject');

    Route::get('/notifications', [ShiftExchangeController::class, 'notifications'])
     ->name('notifications')
     ->middleware('auth');


    // 👉 SALARY – POV ASPRAK (lihat gaji sendiri)
    Route::get('/asprak/salary', [AsprakSalaryController::class, 'index'])
        ->name('asprak.salary.index');

    // 👉 BACKLOG MANAGEMENT – POV ASPRAK (Task Planning & Progress Tracking)
    Route::get('/asprak/backlogs', [BacklogController::class, 'index'])
        ->name('asprak.backlogs.index');
    Route::get('/asprak/backlogs/create', [BacklogController::class, 'create'])
        ->name('asprak.backlogs.create');
    Route::post('/asprak/backlogs', [BacklogController::class, 'store'])
        ->name('asprak.backlogs.store');
    Route::get('/asprak/backlogs/{backlog}', [BacklogController::class, 'show'])
        ->name('asprak.backlogs.show');
    Route::get('/asprak/backlogs/{backlog}/edit', [BacklogController::class, 'edit'])
        ->name('asprak.backlogs.edit');
    Route::put('/asprak/backlogs/{backlog}', [BacklogController::class, 'update'])
        ->name('asprak.backlogs.update');
    Route::patch('/asprak/backlogs/{backlog}/status', [BacklogController::class, 'updateStatus'])
        ->name('asprak.backlogs.updateStatus');
    Route::delete('/asprak/backlogs/{backlog}', [BacklogController::class, 'destroy'])
        ->name('asprak.backlogs.destroy');

    // 👉 REPORT SUBMISSION – POV ASPRAK (Submit & Resubmit Reports)
    Route::get('/asprak/reports', [ReportController::class, 'index'])
        ->name('asprak.reports.index');
    Route::get('/asprak/reports/create', [ReportController::class, 'create'])
        ->name('asprak.reports.create');
    Route::post('/asprak/reports', [ReportController::class, 'store'])
        ->name('asprak.reports.store');
    Route::get('/asprak/reports/{report}', [ReportController::class, 'show'])
        ->name('asprak.reports.show');
    Route::get('/asprak/reports/{report}/download', [ReportController::class, 'download'])
        ->name('asprak.reports.download');
    Route::delete('/asprak/reports/{report}', [ReportController::class, 'destroy'])
        ->name('asprak.reports.destroy');
    Route::get('/asprak/reports/{report}/resubmit', [ReportController::class, 'resubmit'])
        ->name('asprak.reports.resubmit');
    Route::post('/asprak/reports/{report}/resubmit', [ReportController::class, 'updateResubmit'])
        ->name('asprak.reports.updateResubmit');

    // 👉 RESOURCE REQUEST – POV ASPRAK (Submit & Resubmit Resource Requests)
    Route::get('/asprak/resource-requests', [ResourceRequestController::class, 'index'])
        ->name('asprak.resource-requests.index');
    Route::get('/asprak/resource-requests/create', [ResourceRequestController::class, 'create'])
        ->name('asprak.resource-requests.create');
    Route::post('/asprak/resource-requests', [ResourceRequestController::class, 'store'])
        ->name('asprak.resource-requests.store');
    Route::get('/asprak/resource-requests/{resourceRequest}', [ResourceRequestController::class, 'show'])
        ->name('asprak.resource-requests.show');
    Route::delete('/asprak/resource-requests/{resourceRequest}', [ResourceRequestController::class, 'destroy'])
        ->name('asprak.resource-requests.destroy');
    Route::get('/asprak/resource-requests/{resourceRequest}/resubmit', [ResourceRequestController::class, 'resubmit'])
        ->name('asprak.resource-requests.resubmit');
    Route::post('/asprak/resource-requests/{resourceRequest}/resubmit', [ResourceRequestController::class, 'updateResubmit'])
        ->name('asprak.resource-requests.updateResubmit');

    // 👉 SUBMISSIONS – POV ASPRAK (View Assignments & Submit)
    Route::get('/asprak/submissions', [AsprakSubmissionController::class, 'index'])
        ->name('asprak.submissions.index');
    Route::get('/asprak/my-submissions', [AsprakSubmissionController::class, 'mySubmissions'])
        ->name('asprak.submissions.my-submissions');
    Route::get('/asprak/assignments/{assignment}', [AsprakSubmissionController::class, 'showAssignment'])
        ->name('asprak.submissions.show-assignment');
    Route::get('/asprak/assignments/{assignment}/submit', [AsprakSubmissionController::class, 'create'])
        ->name('asprak.submissions.create');
    Route::post('/asprak/assignments/{assignment}/submit', [AsprakSubmissionController::class, 'store'])
        ->name('asprak.submissions.store');
    Route::get('/asprak/submissions/{submission}', [AsprakSubmissionController::class, 'show'])
        ->name('asprak.submissions.show');
    Route::get('/asprak/submissions/{submission}/edit', [AsprakSubmissionController::class, 'edit'])
        ->name('asprak.submissions.edit');
    Route::put('/asprak/submissions/{submission}', [AsprakSubmissionController::class, 'update'])
        ->name('asprak.submissions.update');
    Route::delete('/asprak/submissions/{submission}', [AsprakSubmissionController::class, 'destroy'])
        ->name('asprak.submissions.destroy');
});
