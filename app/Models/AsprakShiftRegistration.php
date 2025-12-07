<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsprakShiftRegistration extends Model
{
    protected $fillable = [
        'shift_slot_id',
        'asprak_id',
    ];

    public function shift()
    {
        return $this->belongsTo(ShiftSlot::class, 'shift_slot_id');
    }

    public function asprak()
    {
        return $this->belongsTo(User::class, 'asprak_id');
    }
}
