<?php

namespace App\Http\Controllers\Praktikan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PraktikanController extends Controller
{
    public function index(){
        return view('praktikan.dashboard');
    }
}