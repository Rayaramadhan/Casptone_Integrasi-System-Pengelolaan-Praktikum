<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function index()
    {
        // asprak yang sedang login
        $asprak = Auth::user();

        // ambil semua salary yang terhubung ke asprak ini
        $salaries = Salary::where('asprak_id', $asprak->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // kirim keduanya ke view
        return view('asprak.salary.index', compact('asprak', 'salaries'));
    }
}
