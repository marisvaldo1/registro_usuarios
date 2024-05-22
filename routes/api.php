<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('usuarios', 'App\Http\Controllers\UsuarioController');
