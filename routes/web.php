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
// Sekarang 4 role: admin, dosen, praktikan, user biasa
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
// 🧑‍🏫 ADMIN ROUTES
// ===============================
Route::middleware(['auth', 'laboranMiddleware'])->group(function () {
    Route::get('/laboran/dashboard', [LaboranController::class, 'index'])
        ->name('laboran.dashboard');
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
// 👨‍💻 USER ROUTES
// ===============================
// user biasa cukup pakai middleware 'auth'
Route::middleware(['auth'])->group(function () {
    Route::get('/asprak/dashboard', [AsprakController::class, 'index'])
        ->name('asprak.dashboard');

    Route::get('/asprak/nilai', [NilaiController::class, 'index'])
    ->name('asprak.nilai.index');
    Route::post('/asprak/nilai', [NilaiController::class, 'store'])
        ->name('asprak.nilai.store');

    //route presensi
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi');

    Route::post('/presensi/checkin', [PresensiController::class, 'checkin'])
        ->name('presensi.checkin');

    Route::post('/presensi/checkout', [PresensiController::class, 'checkout'])
        ->name('presensi.checkout');

    //route tukar shift
    Route::get('/tukar-shift', [ShiftExchangeController::class, 'index'])->name('tukar_shift');
    Route::get('/request-shift', [ShiftExchangeController::class, 'create'])->name('request-shift.create');
    Route::post('/request-shift', [ShiftExchangeController::class, 'store'])->name('request-shift.store');
    Route::post('/shift-exchange/take', [ShiftExchangeController::class, 'take'])->name('shift-exchange.take');
    });
