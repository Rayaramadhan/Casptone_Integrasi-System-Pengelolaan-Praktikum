<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiPraktikum extends Model
{
    protected $fillable = [
        'lab',
        'praktikum',
        'kelas',
        'nim',
        'nama_lengkap',
        'modul',
        'nilai_total',
        'bukti_nilai_modul',
    ];
}
