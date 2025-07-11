<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\User;
use App\Livewire\Admin\Property;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\TenantSettings\Index as TenantSettingsIndex;
use App\Livewire\Tenant\Properties\Index;

// auth()->logout();

Route::view('/teste', 'imoveis');
Route::view('/teste1', 'welcome');


Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/properties', Property\Index::class)->name('properties.index');
    Route::get('/properties/create', Property\Create::class)->name('properties.create');

    Route::get('/users', User\Index::class)->name('users.index');
    Route::get('/users/create', User\Create::class)->name('users.create');

    Route::get('/site-settings', TenantSettingsIndex::class)->name('tenant-settings.index');

    // Route::get('/site-settings', \App\Livewire\Admin\SiteSettings::class)->name('site-settings');
});

Route::get('/demo', [HomeController::class, 'demo'])->name('home.demo');
Route::prefix('{tenantSlug}')
    ->middleware(['web', 'set.tenant'])
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('tenant.home');
        Route::get('/imoveis', [HomeController::class, 'properties'])->name('tenant.properties');
        // Route::get('/imoveis/{id}', Index::class)->name('tenant.property');
        Route::get('/imoveis/{id}', [HomeController::class, 'property'])->name('tenant.property');
    });

// Opcional: Rota para o site principal da plataforma (se você tiver um)
Route::get('/', [HomeController::class, 'landing'])->name('platform.home');

// Route::get('/', [HomeController::class, 'landing'])->name('home.landing');
// Route::get('/imoveis', [HomeController::class, 'properties'])->name('home.properties');
Route::get('/imovel/{id}', [HomeController::class, 'property'])->name('home.property');

