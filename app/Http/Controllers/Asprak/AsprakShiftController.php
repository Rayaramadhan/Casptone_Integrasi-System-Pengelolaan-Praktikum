<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\ShiftSlot;
use App\Models\AsprakShiftRegistration;
use Illuminate\Support\Facades\Auth;

class AsprakShiftController extends Controller
{
    // 1️⃣ Tampilkan semua jadwal dari Laboran + status saya
    public function index()
    {
        $asprakId = Auth::id();

        $myRegs = AsprakShiftRegistration::where('asprak_id', $asprakId)->get();
        $takenCount   = $myRegs->count();                         // total shift yang sudah diambil
        $takenShiftIds = $myRegs->pluck('shift_slot_id')->all();  // id shift yang sudah diambil

        $shifts = ShiftSlot::with('registrations')->orderBy('date')->get();

        return view('asprak.jadwal.index', compact('shifts', 'takenCount', 'takenShiftIds'));
    }

    // 2️⃣ Halaman konfirmasi ambil shift
    public function ambil($id)
    {
        $asprakId = Auth::id();

        $shift = ShiftSlot::with('registrations')->findOrFail($id);

        $takenCount = AsprakShiftRegistration::where('asprak_id', $asprakId)->count();
        $isTaken    = AsprakShiftRegistration::where('shift_slot_id', $id)
                        ->where('asprak_id', $asprakId)
                        ->exists();

        return view('asprak.jadwal.ambil', compact('shift', 'takenCount', 'isTaken'));
    }

    // 3️⃣ Proses simpan pengambilan shift
    public function ambilStore($id)
    {
        $asprakId = Auth::id();
        $shift    = ShiftSlot::with('registrations')->findOrFail($id);

        // Cegah double ambil shift yg sama
        if (AsprakShiftRegistration::where('shift_slot_id', $shift->id)
                ->where('asprak_id', $asprakId)
                ->exists()) {
            return back()->with('error', 'Anda sudah mengambil shift ini.');
        }

        // Cek total shift yang sudah diambil
        $takenCount = AsprakShiftRegistration::where('asprak_id', $asprakId)->count();
        if ($takenCount >= 3) {
            return back()->with('error', 'Anda sudah mengambil maksimal 3 shift. Batalkan salah satu jika ingin mengganti.');
        }

        // Cek kuota penuh
        if ($shift->registrations->count() >= $shift->capacity) {
            return back()->with('error', 'Kuota shift penuh.');
        }

        // Simpan
        AsprakShiftRegistration::create([
            'shift_slot_id' => $shift->id,
            'asprak_id'     => $asprakId,
        ]);

        return redirect()->route('asprak.jadwal.index')
            ->with('success', 'Shift berhasil diambil!');
    }

    // 4️⃣ Batalkan shift yang sudah diambil
    public function batal($id)
    {
        $asprakId = Auth::id();

        $reg = AsprakShiftRegistration::where('shift_slot_id', $id)
            ->where('asprak_id', $asprakId)
            ->first();

        if (! $reg) {
            return back()->with('error', 'Anda belum mengambil shift ini.');
        }

        $reg->delete();

        return back()->with('success', 'Shift berhasil dibatalkan.');
    }
}
