<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\User;
use App\Livewire\Admin\Property;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\TenantSettings\Index as TenantSettingsIndex;
// auth()->logout();


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

Route::prefix('{tenantSlug}')
    ->middleware(['web', 'set.tenant'])
    ->group(function () {
        // Home do site do tenant
        Route::get('/', [HomeController::class, 'index'])->name('tenant.home');
        // Exemplo de rota para Imóveis do tenant
        Route::get('/imoveis', [HomeController::class, 'properties'])->name('tenant.properties');
        // Exemplo de rota para Contato do tenant
        // Route::get('/contato', [ContactController::class, 'showContactForm'])->name('tenant.contact'); // Assumindo ContactController
        // ... outras rotas do site do tenant
    });

// Opcional: Rota para o site principal da plataforma (se você tiver um)
Route::get('/', [HomeController::class, 'landing'])->name('platform.home');

// Route::get('/', [HomeController::class, 'landing'])->name('home.landing');
// Route::get('/site', [HomeController::class, 'index'])->name('home.index');
// Route::get('/imoveis', [HomeController::class, 'properties'])->name('home.properties');
// Route::get('/imovel/{id}', [HomeController::class, 'property'])->name('home.property');

