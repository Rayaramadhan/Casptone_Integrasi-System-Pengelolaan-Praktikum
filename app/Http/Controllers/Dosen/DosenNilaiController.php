<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\NilaiPraktikum;

class DosenNilaiController extends Controller
{
    public function index()
    {
        // Ambil semua nilai yang diinput asprak
        $nilai = NilaiPraktikum::latest()->get();

        return view('dosen.nilai.index', compact('nilai'));
    }
}
