<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\User;
use App\Livewire\Admin\Property;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
// auth()->logout();
Route::get('/', [HomeController::class, 'landing'])->name('home.landing');
Route::get('/site', [HomeController::class, 'index'])->name('home.index');
Route::get('/imoveis', [HomeController::class, 'properties'])->name('home.properties');
Route::get('/imovel/{id}', [HomeController::class, 'property'])->name('home.property');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/properties', Property\Index::class)->name('properties.index');
    Route::get('/properties/create', Property\Create::class)->name('properties.create');

    Route::get('/users', User\Index::class)->name('users.index');
    Route::get('/users/create', User\Create::class)->name('users.create');

    Route::get('/site-settings', \App\Livewire\Admin\SiteSettings::class)->name('site-settings');
});
