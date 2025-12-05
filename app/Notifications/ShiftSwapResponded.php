<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ShiftSwapResponded extends Notification
{
    use Queueable;

    protected $request;
    protected $status;

    public function __construct($request, $status)
    {
        $this->request = $request;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $action = $this->status === 'diterima' ? 'menerima' : 'menolak';
        return [
            'message' => $this->request->targetUser->name . " {$action} permintaan tukar shift Anda.",
            'url' => route('tukar_shift'),
        ];
    }
}