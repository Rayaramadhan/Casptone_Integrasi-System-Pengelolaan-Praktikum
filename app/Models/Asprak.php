<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // penting
use Illuminate\Notifications\Notifiable;

class Asprak extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'aspraks'; // pastikan nama tabel benar

    /**
     * Field yang boleh diisi mass assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',   // kalau punya kolom usertype (opsional)
    ];

    /**
     * Hidden fields untuk keamanan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting field otomatis.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELASI: Asprak punya banyak salary.
     */
    public function salaries()
    {
        return $this->hasMany(Salary::class, 'asprak_id');
    }
}
