<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\ShiftSlot;
use Illuminate\Http\Request;

class ShiftSlotController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = ShiftSlot::query()
            ->orderBy('date')
            ->orderBy('start_time');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('praktikum', 'like', "%{$search}%")
                ->orWhere('lab', 'like', "%{$search}%") // Tambahkan search by lab
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('class_code', 'like', "%{$search}%");
            });
        }

        $slots = $query->get();

        return view('laboran.jadwal.index', [
            'slots'  => $slots,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('laboran.jadwal.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lab'        => ['required', 'string', 'max:50'],
            'praktikum'  => ['required', 'string', 'max:191'],
            'name'       => ['required', 'string', 'max:50'],
            'class_code' => ['required', 'string', 'max:50'],
            'date'       => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
            'capacity'   => ['required', 'integer', 'min:1'],
        ]);

        ShiftSlot::create($validated + [
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('laboran.jadwal.index')
            ->with('success', 'Jadwal shift berhasil disimpan.');
    }

    public function edit(ShiftSlot $slot)
    {
        return view('laboran.jadwal.edit', [
            'slot' => $slot,
        ]);
    }

    public function update(Request $request, ShiftSlot $slot)
    {
        $validated = $request->validate([
            'praktikum'  => ['required', 'string', 'max:191'],
            'name'       => ['required', 'string', 'max:50'],
            'class_code' => ['required', 'string', 'max:50'],
            'date'       => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
            'capacity'   => ['required', 'integer', 'min:1'],
        ]);

        $slot->update($validated);

        return redirect()
            ->route('laboran.jadwal.index')
            ->with('success', 'Jadwal shift berhasil diupdate.');
    }

    public function destroy(ShiftSlot $slot)
    {
        $slot->delete();

        return redirect()
            ->route('laboran.jadwal.index')
            ->with('success', 'Jadwal shift berhasil dihapus.');
    }
}
