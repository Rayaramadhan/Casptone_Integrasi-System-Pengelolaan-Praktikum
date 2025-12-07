<?php

namespace App\Http\Controllers\Praktikan;

use App\Http\Controllers\Controller;
use App\Models\ShiftSlot;

class PraktikanShiftController extends Controller
{
    public function index()
    {
        // Ambil semua jadwal yang dibuat Laboran
        $shifts = ShiftSlot::orderBy('date', 'asc')->get();

        return view('praktikan.jadwal.index', compact('shifts'));
    }
}
