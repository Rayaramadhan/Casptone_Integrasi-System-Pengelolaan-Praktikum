<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    // LIST + FILTER (tampilan tabel seperti desain kamu)
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
        // asprak = user dengan usertype = 'user' (lihat screenshot)
        // kalau nanti kamu ubah ke 'asprak', ganti saja nilainya
        $aspraks = User::where('usertype', 'user')
            ->orderBy('name')
            ->get();

        return view('laboran.salary.create', compact('aspraks'));
    }

    // SIMPAN DATA
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
            'bukti_foto'     => ['nullable', 'image', 'max:2048'], // max ~2MB
        ]);

        $data['status']     = $data['status'] ?? 'success';
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        // simpan file ke storage/app/public/salary_receipts
        if ($request->hasFile('bukti_foto')) {
            $data['bukti_foto'] = $request->file('bukti_foto')
                ->store('salary_receipts', 'public');
        }

        Salary::create($data);

        return redirect()
            ->route('laboran.salary.index')
            ->with('success', 'Data gaji berhasil disimpan.');
    }
}