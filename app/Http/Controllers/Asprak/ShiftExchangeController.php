<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use App\Models\ShiftRequest;
use Illuminate\Http\Request;
use App\Notifications\ShiftSwapRequested;
use App\Notifications\ShiftSwapResponded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShiftExchangeController extends Controller
{
    public function index () {
        $requests = ShiftRequest::with(['requester', 'targetUser'])
            ->where('target_user_id', Auth::id())
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('asprak.tukar_shift', compact('requests'));
    }

    public function create() {
        $users = \App\Models\User::where('usertype', 'asprak')->where('id', '!=', Auth::id())->orderBy('name')->get();
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

        $shiftRequest = ShiftRequest::create([
            'requester_id'         => Auth::id(),
            'target_user_id'       => $request->target_user_id,
            'requester_date'       => $request->my_shift_date,
            'requester_time'       => $request->my_shift_time,
            'requester_shift_code' => $request->my_shift_code,
            'target_date'          => $request->target_date,
            'target_time'          => $request->target_time,
            'target_shift_code'    => $request->target_shift_code,
            'message'              => $request->message,
            'status'               => 'pending',
        ]);

        // Kirim notifikasi ke orang yang dituju (kalau user masih ada)
        $targetUser = \App\Models\User::find($request->target_user_id);
        if ($targetUser) {
            $targetUser->notify(new ShiftSwapRequested($shiftRequest));
        }

        return response()->json(['success' => true]);
    }

    public function accept(Request $request)
    {
        $shiftRequest = ShiftRequest::where('target_user_id', Auth::id())
            ->where('id', $request->id)
            ->where('status', 'pending')
            ->firstOrFail();

        DB::transaction(function () use ($shiftRequest) {
            $shiftRequest->update([
                'status'    => 'accepted',
                'taken_by'  => Auth::id(),
                'taken_at'  => now(),
            ]);

            // HANYA kirim notif ke requester (bukan ke diri sendiri)
            $requester = User::find($shiftRequest->requester_id);
            if ($requester && $requester->id !== Auth::id()) {
                $requester->notify(new ShiftSwapResponded($shiftRequest, 'diterima'));
            }
        });

        return redirect()->back()->with('success', 'Shift berhasil ditukar!');
    }

    /**
     * Tolak permintaan
     */
    public function reject(Request $request)
    {
        $shiftRequest = ShiftRequest::where('target_user_id', Auth::id())
            ->where('id', $request->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $shiftRequest->update(['status' => 'rejected']);

        // Notifikasi ke requester (aman dari null)
        $requester = User::find($shiftRequest->requester_id);
        if ($requester && $requester->id !== Auth::id()) {
            $requester->notify(new ShiftSwapResponded($shiftRequest, 'ditolak'));
        }

        return redirect()->back()->with('success', 'Permintaan telah ditolak');
    }

    public function notifications()
    {
        // Tandai semua sebagai sudah dibaca saat buka halaman
        Auth::user()->unreadNotifications->markAsRead();

        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('asprak.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        Auth::user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }
}