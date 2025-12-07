<?php

namespace App\Http\Controllers\Praktikan;

use App\Http\Controllers\Controller;
use App\Models\NilaiPraktikum;

class PraktikanNilaiController extends Controller
{
    public function index()
    {
        // ambil semua nilai yang sudah diinput asprak
        $nilai = NilaiPraktikum::latest()->get();

        // view: resources/views/praktikan/nilai/index.blade.php
        return view('praktikan.nilai.index', compact('nilai'));
    }
}
