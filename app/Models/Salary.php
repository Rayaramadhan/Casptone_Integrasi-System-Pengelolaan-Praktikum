<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'asprak_id',
        'nama_mahasiswa',
        'nim',
        'kelas',
        'jumlah_shift',
        'slip_gaji',
        'status',
        'bukti_foto',
        'created_by',
        'updated_by',
    ];

     public function getBuktiFotoUrlAttribute(): ?string
    {
        return $this->bukti_foto
            ? asset('storage/' . $this->bukti_foto)
            : null;
    }

    public function asprak()
    {
        // asprak = row di tabel users
        return $this->belongsTo(User::class, 'asprak_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
