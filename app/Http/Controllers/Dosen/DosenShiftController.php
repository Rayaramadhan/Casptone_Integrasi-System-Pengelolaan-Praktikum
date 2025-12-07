<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ShiftSlot;

class DosenShiftController extends Controller
{
    // Tampilkan semua jadwal shift yang dibuat Laboran
    public function index()
    {
        $shifts = ShiftSlot::with('registrations')
            ->orderBy('date')
            ->get();

        return view('dosen.jadwal.index', compact('shifts'));
    }
}
