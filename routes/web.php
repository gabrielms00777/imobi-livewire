<?php

use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/imovel', 'imovel');
Route::view('/imoveis', 'imoveis');
Route::get('/users', Welcome::class);
