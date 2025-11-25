<?php

namespace App\Http\Controllers\Dosen;   // WAJIB persis ini

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        // pastikan view ini memang ada:
        // resources/views/dosen/dashboard.blade.php
        return view('dosen.dashboard');
    }
}
