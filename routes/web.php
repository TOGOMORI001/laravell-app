<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/heure', function () {
    return view('heure', [
        'heure' => now()->format('d/m/Y H:i:s'),
    ]);
});

Route::view('/welcome', 'welcome');
