<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\NilaiPraktikum;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    // ============================
    // GET /asprak/nilai  (INDEX)
    // ============================
    public function index()
    {
        $nilai = NilaiPraktikum::latest()->get();

        return view('asprak.nilaiouput', compact('nilai'));
    }

    // ============================
    // POST /asprak/nilai  (STORE)
    // ============================
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

            // izinkan pdf, jpg, jpeg, png
            'bukti_modul' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'bukti_modul.mimes' => 'Bukti nilai harus berupa file PDF / JPG / JPEG / PNG.',
        ]);

        // buat folder public/storage/bukti-nilai jika belum ada
        $uploadDir = public_path('storage/bukti-nilai');
        if (! is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        if ($request->hasFile('bukti_modul')) {
            $file     = $request->file('bukti_modul');
            $filename = time().'_'.$file->getClientOriginalName();

            $file->move($uploadDir, $filename);

            $data['bukti_nilai_modul'] = 'storage/bukti-nilai/'.$filename;
        }

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
            ->route('asprak.nilai.index')
            ->with('success', 'Data nilai berhasil disimpan.');
    }


    // ============================
    // GET /asprak/nilai/{id}/edit  (EDIT)
    // ============================
    public function edit($id)
    {
        $nilai = NilaiPraktikum::findOrFail($id);

        return view('asprak.nilai_edit', compact('nilai'));
    }


    // ============================
    // PUT /asprak/nilai/{id}  (UPDATE)
    // ============================
    public function update(Request $request, $id)
    {
        $nilai = NilaiPraktikum::findOrFail($id);

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

        // jika upload file baru, replace file lama
        if ($request->hasFile('bukti_modul')) {

            // hapus file lama jika ada
            if ($nilai->bukti_nilai_modul && file_exists(public_path($nilai->bukti_nilai_modul))) {
                unlink(public_path($nilai->bukti_nilai_modul));
            }

            $uploadDir = public_path('storage/bukti-nilai');
            if (! is_dir($uploadDir)) {
                @mkdir($uploadDir, 0755, true);
            }

            $file     = $request->file('bukti_modul');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move($uploadDir, $filename);

            $data['bukti_nilai_modul'] = 'storage/bukti-nilai/'.$filename;
        }

        // update data
        $nilai->update([
            'lab'               => $data['lab'],
            'praktikum'         => $data['praktikum'],
            'kelas'             => $data['kelas'],
            'nim'               => $data['nim'],
            'nama_lengkap'      => $data['nama'],
            'modul'             => $data['modul'],
            'nilai_total'       => $data['nilai_total'],
            'bukti_nilai_modul' => $data['bukti_nilai_modul'] ?? $nilai->bukti_nilai_modul,
        ]);

        return redirect()
            ->route('asprak.nilai.index')
            ->with('success', 'Data nilai berhasil diperbarui.');
    }


    // ============================
    // DELETE /asprak/nilai/{id} (DESTROY)
    // ============================
    public function destroy($id)
    {
        $nilai = NilaiPraktikum::findOrFail($id);

        if ($nilai->bukti_nilai_modul && file_exists(public_path($nilai->bukti_nilai_modul))) {
            unlink(public_path($nilai->bukti_nilai_modul));
        }

        $nilai->delete();

        return redirect()
            ->route('asprak.nilai.index')
            ->with('success', 'Data nilai berhasil dihapus.');
    }
}
