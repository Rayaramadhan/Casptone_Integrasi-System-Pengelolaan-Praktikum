<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\NilaiPraktikum;

class LaboranNilaiController extends Controller
{
    public function index()
    {
        // Ambil semua nilai yang sudah diinput asprak
        $nilai = NilaiPraktikum::latest()->get();

        return view('laboran.nilai.index', compact('nilai'));
    }
}
