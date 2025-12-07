<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    // LIST + FILTER (tampilan tabel)
    public function index(Request $request)
    {
        $query = Salary::with('asprak');

        if ($request->filled('nim')) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        if ($request->filled('nama')) {
            $query->where('nama_mahasiswa', 'like', '%' . $request->nama . '%');
        }

        $salaries = $query->orderByDesc('created_at')->paginate(10);

        return view('laboran.salary.index', compact('salaries'));
    }

    // FORM INPUT / CREATE
    public function create()
    {
        // asprak = user dengan usertype = 'user'
        $aspraks = User::where('usertype', 'user')
            ->orderBy('name')
            ->get();

        return view('laboran.salary.create', compact('aspraks'));
    }

    /// SIMPAN DATA
    public function store(Request $request)
    {
        $data = $request->validate([
            'asprak_id'      => ['nullable', 'exists:users,id'],
            'nama_mahasiswa' => ['required', 'string', 'max:255'],
            'nim'            => ['required', 'string', 'max:20'],
            'kelas'          => ['nullable', 'string', 'max:30'],
            'jumlah_shift'   => ['required', 'integer', 'min:0'],
            'slip_gaji'      => ['required', 'integer', 'min:0'],
            'status'         => ['nullable', 'string', 'max:20'],
            'bukti_foto'     => ['nullable', 'image', 'max:4096'],
        ]);

        $data['status']     = $data['status'] ?? 'success';
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        // ==========================
        // SIMPAN FILE KE public/storage/salary_receipts
        // ==========================
        if ($request->hasFile('bukti_foto')) {

            $folder = public_path('/storage/salary_receipts');

            // jika folder belum ada → buat
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $file     = $request->file('bukti_foto');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            // simpan file fisik
            $file->move($folder, $filename);

            // path yang disimpan ke database
            $data['bukti_foto'] = 'storage/salary_receipts/' . $filename;
        }

        Salary::create($data);

        return redirect()
            ->route('laboran.salary.index')
            ->with('success', 'Data gaji berhasil disimpan.');
    }

    // =======================
    // EDIT FORM
    // =======================
    public function edit($id)
    {
        $salary = Salary::findOrFail($id);

        $aspraks = User::where('usertype', 'user')->orderBy('name')->get();

        return view('laboran.salary.edit', compact('salary', 'aspraks'));
    }

    // =======================
    // UPDATE DATA
    // =======================
    public function update(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);

        $data = $request->validate([
            'asprak_id'      => ['nullable', 'exists:users,id'],
            'nama_mahasiswa' => ['required', 'string', 'max:255'],
            'nim'            => ['required', 'string', 'max:20'],
            'kelas'          => ['nullable', 'string', 'max:30'],
            'jumlah_shift'   => ['required', 'integer', 'min:0'],
            'slip_gaji'      => ['required', 'integer', 'min:0'],
            'status'         => ['nullable', 'string', 'max:20'],
            'bukti_foto'     => ['nullable', 'image', 'max:4096'],
        ]);

        $data['updated_by'] = Auth::id();

        // Upload FILE BARU jika ada
        if ($request->hasFile('bukti_foto')) {

            $folder = public_path('storage/salary_receipts');
            if (!file_exists($folder)) mkdir($folder, 0755, true);

            $file = $request->file('bukti_foto');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move($folder, $filename);

            // HAPUS FILE LAMA jika ada
            if ($salary->bukti_foto && file_exists(public_path($salary->bukti_foto))) {
                unlink(public_path($salary->bukti_foto));
            }

            $data['bukti_foto'] = 'storage/salary_receipts/' . $filename;
        }

        $salary->update($data);

        return redirect()->route('laboran.salary.index')
            ->with('success', 'Data salary berhasil diperbarui.');
    }

    // =======================
    // DELETE
    // =======================
    public function destroy($id)
    {
        $salary = Salary::findOrFail($id);

        // hapus file
        if ($salary->bukti_foto && file_exists(public_path($salary->bukti_foto))) {
            unlink(public_path($salary->bukti_foto));
        }

        $salary->delete();

        return redirect()->route('laboran.salary.index')
            ->with('success', 'Data salary berhasil dihapus.');
    }

}
