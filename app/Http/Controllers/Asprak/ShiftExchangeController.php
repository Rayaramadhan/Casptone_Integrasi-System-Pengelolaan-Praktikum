<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\ShiftRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftExchangeController extends Controller
{
    public function index () {
        $requests = ShiftRequest::with(['requester', 'targetUser'])
            ->where('status', 'pending')
            ->orWhere(function ($q) {
                $q->where('status', 'taken')
                  ->where('taken_by', Auth::id());
            })
            ->latest()
            ->get();

        return view('asprak.tukar_shift', compact('requests'));
    }

    public function create() {
        $users = \App\Models\User::where('id', '!=', Auth::id())->get();
        $myShifts = []; // Bisa diisi dari jadwal user (misal dari tabel shift lain)
        // Untuk demo, kita hardcode dulu
        $myShifts = [
            ['date' => '2025-10-23', 'time' => '06.30 - 09.30', 'code' => 'SHIFT 3 (SI-48-06)'],
            ['date' => '2025-10-23', 'time' => '15.30 - 18.30', 'code' => 'SHIFT 5 (SI-46-07)'],
        ];

        return view('asprak.request_shift', compact('users', 'myShifts'));
    }

    public function store(Request $request) {
        $request->validate([
            'my_shift_date' => 'required|date',
            'my_shift_time' => 'required',
            'my_shift_code' => 'required',
            'target_user_id' => 'required|exists:users,id',
            'target_date' => 'required|date',
            'target_time' => 'required',
            'target_shift_code' => 'required',
            'message' => 'nullable|string',
        ]);

        ShiftRequest::create([
            'requester_id' => Auth::id(),
            'target_user_id' => $request->target_user_id,
            'requester_date' => $request->my_shift_date,
            'requester_time' => $request->my_shift_time,
            'requester_shift_code' => $request->my_shift_code,
            'target_date' => $request->target_date,
            'target_time' => $request->target_time,
            'target_shift_code' => $request->target_shift_code,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return response()->json(['success' => true]);
    }

    public function take(Request $request)
    {
        $shiftRequest = ShiftRequest::findOrFail($request->id);

        if ($shiftRequest->status === 'taken') {
            return response()->json(['success' => false, 'message' => 'Sudah diambil orang lain']);
        }

        $shiftRequest->update([
            'status' => 'taken',
            'taken_by' => Auth::id(),
            'taken_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
