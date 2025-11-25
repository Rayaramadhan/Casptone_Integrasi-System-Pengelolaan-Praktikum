<?php

namespace App\Http\Controllers\Asprak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsprakController extends Controller
{
    public function index(){
        return view('asprak.dashboard');
    }
}