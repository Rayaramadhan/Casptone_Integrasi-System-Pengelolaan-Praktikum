<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftRequest extends Model
{
    protected $guarded = ['id'];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function takenBy()
    {
        return $this->belongsTo(User::class, 'taken_by');
    }

    public function isTaken()
    {
        return $this->status === 'taken';
    }
}
