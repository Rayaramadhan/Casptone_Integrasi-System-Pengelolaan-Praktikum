<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ShiftSwapRequested extends Notification
{
    use Queueable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        return ['database']; // Bisa tambah 'mail' kalau mau email
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->request->requester->name . ' meminta tukar shift dengan Anda.',
            'url' => route('tukar_shift'),
            'request_id' => $this->request->id,
        ];
    }
}