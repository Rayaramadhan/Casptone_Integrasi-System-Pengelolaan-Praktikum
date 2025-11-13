<?php

use Illuminate\Support\Facades\Route;

// Landing Page SIAP
Route::get('/', function () {
    return view('menu_utama');   // sesuaikan dengan nama view-mu
})->name('menu_utama');
