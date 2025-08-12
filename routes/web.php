<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TenantController;

// =============================================================================
// LANDLORD ROUTES (Main domain and landlord subdomain)
// =============================================================================
Route::domain('multitenant.test')->group(function () {

    // Public routes (shared between both domains)
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');

    // Authentication routes
    Route::middleware('guest')->group(function () {
        Route::get('/register', [RegistrationController::class, 'step1'])->name('register');
        Route::post('/register/step1', [RegistrationController::class, 'storeStep1'])->name('register.step1');
        Route::post('/register', [AuthController::class, 'register']);

        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Registration continuation routes (for authenticated users with incomplete registration)
    Route::middleware('auth')->group(function () {
        // Logout (always available)
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Registration continuation (for incomplete registrations)
        Route::get('/register/step2', [RegistrationController::class, 'step2'])->name('register.step2');
        Route::post('/register/step2', [RegistrationController::class, 'storeStep2']);
        Route::get('/register/step3', [RegistrationController::class, 'step3'])->name('register.step3');
        Route::post('/register/step3', [RegistrationController::class, 'storeStep3']);
    });

    Route::middleware(['auth', 'registration.complete'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    });
});

Route::domain('landlord.multitenant.test')->group(function () {

    // Public routes (shared between both domains)
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');

    // Authentication routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Registration continuation routes (for authenticated users with incomplete registration)
    Route::middleware('auth')->group(function () {
        // Logout (always available)
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });
});


Route::domain('landlord.multitenant.test')
    ->middleware(['auth', 'role:admin,super-admin'])
    ->prefix('admin')
    ->name('landlord.admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('tenants', TenantController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

        // Tenant routes with specific permissions
        Route::middleware('permission:tenants.view')->group(function () {
            Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
            Route::get('/tenants/export', [AdminController::class, 'exportTenants'])->name('tenants.export');
        });

        Route::middleware('permission:tenants.edit')->group(function () {
            Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
            Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
        });

        Route::middleware('permission:tenants.delete')->group(function () {
            Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');
        });
    });


Route::domain('{tenant}.multitenant.test')
    ->middleware(['tenant'])
    ->name('tenant.')
    ->group(function () {
        
        // Public routes
        Route::get('/', [App\Http\Controllers\Tenant\HomeController::class, 'index'])->name('home');
        Route::get('/privacy-policy', [App\Http\Controllers\Tenant\HomeController::class, 'privacyPolicy'])->name('privacy.policy');

        // Authentication routes
        Route::middleware('guest:tenant')->group(function () {
            Route::get('/register', [App\Http\Controllers\Tenant\AuthController::class, 'showRegisterForm'])->name('register');
            Route::post('/register', [App\Http\Controllers\Tenant\AuthController::class, 'register']);

            Route::get('/login', [App\Http\Controllers\Tenant\AuthController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [App\Http\Controllers\Tenant\AuthController::class, 'login']);
        });

        // Tenant authenticated routes
        Route::middleware('auth:tenant')->group(function () {
            Route::post('/logout', [App\Http\Controllers\Tenant\AuthController::class, 'logout'])->name('logout');
            Route::get('/dashboard', [App\Http\Controllers\Tenant\HomeController::class, 'dashboard'])->name('dashboard');
        });
    });