<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaboranController extends Controller
{
    public function index(){
        return view('laboran.dashboard');
    }
}
