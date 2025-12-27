<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftSlot extends Model
{
    protected $table = 'shift_slots';

    // 👇 WAJIB: masukkan created_by ke fillable
    protected $fillable = [
        'lab',
        'praktikum',
        'name',
        'class_code',
        'date',
        'start_time',
        'end_time',
        'capacity',
        'created_by',
    ];

    // Relasi ke pendaftaran asprak
    public function registrations()
    {
        return $this->hasMany(AsprakShiftRegistration::class, 'shift_slot_id');
    }

    // (opsional) Relasi ke user pembuat shift
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
