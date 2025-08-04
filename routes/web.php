<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\HomeController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\User;
use App\Livewire\Admin\Property;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\TenantSettings\Index as TenantSettingsIndex;
use App\Livewire\Tenant\Properties\Index;
use Illuminate\Support\Facades\Auth;

// auth()->logout();

Route::view('/teste', 'imoveis');
Route::view('/teste1', 'welcome');


Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
 
    return redirect('/');
})->name('logout');

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/properties', Property\Index::class)->name('properties.index');
    Route::get('/properties/create', Property\Create::class)->name('properties.create');
    Route::get('/properties/{property}/edit', Property\Edit::class)->name('properties.edit');

    // Route::get('/users', User\Index::class)->name('users.index');
    // Route::get('/users/create', User\Create::class)->name('users.create');

    Route::get('/site-settings', TenantSettingsIndex::class)->name('tenant-settings.index');

});

Route::get('/demo', [DemoController::class, 'home'])->name('demo.home');
Route::get('/demo/imoveis', [DemoController::class, 'properties'])->name('demo.properties');
Route::get('/demo/imoveis/{id}', [DemoController::class, 'property'])->name('demo.property');

Route::prefix('{tenantSlug}')
    ->middleware(['web', 'set.tenant'])
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('tenant.home');
        Route::get('/imoveis', [HomeController::class, 'properties'])->name('tenant.properties');
        Route::get('/imoveis/{property}', [HomeController::class, 'property'])->name('tenant.properties.show');
});

Route::view('/', 'home.landing')->name('platform.home');


