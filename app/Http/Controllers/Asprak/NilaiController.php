<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\NilaiPraktikum;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        // ambil semua data nilai (boleh diganti paginate)
        $nilai = NilaiPraktikum::latest()->get();

        // view: resources/views/user/nilaiouput.blade.php
        return view('asprak.nilaiouput', compact('nilai'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lab'         => 'required|string|max:100',
            'praktikum'   => 'required|string|max:150',
            'kelas'       => 'required|string|max:50',
            'nim'         => 'required|string|max:50',
            'nama'        => 'required|string|max:150',
            'modul'       => 'required|string|max:150',
            'nilai_total' => 'required|numeric|min:0|max:100',
            'bukti_modul' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // handle upload (kalau ada)
        if ($request->hasFile('bukti_modul')) {
            $data['bukti_nilai_modul'] = $request->file('bukti_modul')
                ->store('bukti-nilai', 'public'); // storage/app/public/bukti-nilai
        }

        // sesuaikan nama kolom dengan migration
        NilaiPraktikum::create([
            'lab'               => $data['lab'],
            'praktikum'         => $data['praktikum'],
            'kelas'             => $data['kelas'],
            'nim'               => $data['nim'],
            'nama_lengkap'      => $data['nama'],
            'modul'             => $data['modul'],
            'nilai_total'       => $data['nilai_total'],
            'bukti_nilai_modul' => $data['bukti_nilai_modul'] ?? null,
        ]);

        return redirect()
            ->route('asprak.nilai.index')   // ⬅️ disesuaikan dengan nama route
            ->with('success', 'Data nilai berhasil disimpan.');
    }
}
