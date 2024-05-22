<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('register');
});

Route::get('/register', function () {
    return view('register');
});
