<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $guarded = [];

    protected $casts = [
        'check_in_at'  => 'datetime',
        'check_out_at' => 'datetime',
        'tanggal'      => 'date', // optional, biar tanggal juga jadi Carbon
    ];

    //protected $dates = ['check_in_at', 'check_out_at', 'tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
