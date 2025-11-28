<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index()
    {
        $today = today()->toDateString();

        // ambil semua presensi hari ini
        $todayPresensis = Presensi::where('user_id', auth()->id())
            ->whereDate('tanggal', today())
            ->orderBy('check_in_at')
            ->get();

        // riwayat (max 30 hari terakhir)
        $history = Presensi::where('user_id', Auth::id())
            ->orderByDesc('tanggal')
            ->orderByDesc('check_in_at')
            ->limit(50)
            ->get();

        return view('asprak.presensi_asprak', compact('todayPresensis', 'history'));
    }

    public function checkin(Request $request)
    {
        $request->validate([
            'shift'       => 'required|string',
            'proof'       => 'required|file|mimes:jpeg,png,jpg,pdf|max:5048', // max 5MB
        ]);

        $today = today()->toDateString();

        // cek apakah sudah check-in hari ini di shift yang sama
        $exist = Presensi::where('user_id', Auth::id())
            ->where('tanggal', $today)
            ->where('shift', $request->shift)
            ->first();

        if ($exist && $exist->check_in_at) {
            return back()->with('error', 'Kamu sudah check-in untuk shift ini hari ini.');
        }

        // upload bukti
        $path = $request->file('proof')->store('proofs', 'public');

        if ($exist) {
            $exist->update([
                'bukti_hadir'   => $path,
                'check_in_at'  => now(),
            ]);
            $presensi = $exist;
        } else {
            $presensi = Presensi::create([
                'user_id'    => Auth::id(),
                'tanggal'       => $today,
                'shift'      => $request->shift,
                'bukti_hadir' => $path,
                'check_in_at'=> now(),
            ]);
        }

        return back()->with('success', 'Check-in berhasil!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'presensi_id' => 'required|exists:presensis,id'
        ]);

        $presensi = Presensi::where('id', $request->presensi_id)
            ->where('user_id', auth()->id())
            ->whereNotNull('check_in_at')
            ->whereNull('check_out_at')
            ->firstOrFail();

        $presensi->update([
            'check_out_at' => now()
        ]);

        return back()->with('success', 'Check-out berhasil untuk shift ' . $presensi->shift);
    }
}
