<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Halaman 1: Landing Page (publik, tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Halaman 2: Generator Sertifikat (Admin Lembaga)
| Middleware 'role:admin' → hanya admin lembaga yang bisa akses
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('dashboard')->group(function () {
    Route::get('/', [CertificateController::class, 'index'])->name('certificate.index');
    Route::post('/upload-logo', [CertificateController::class, 'uploadLogo'])->name('certificate.uploadLogo');
});

/*
|--------------------------------------------------------------------------
| Halaman 3: Super Admin Panel (Kelola Akun Lembaga)
| Middleware 'role:super_admin' → hanya super admin yang bisa akses
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.index');

    // CRUD Lembaga
    Route::post('/institutions', [SuperAdminController::class, 'storeInstitution'])->name('superadmin.institutions.store');
    Route::patch('/institutions/{institution}/toggle', [SuperAdminController::class, 'toggleInstitution'])->name('superadmin.institutions.toggle');
    Route::delete('/institutions/{institution}', [SuperAdminController::class, 'destroyInstitution'])->name('superadmin.institutions.destroy');

    // CRUD Admin
    Route::post('/institutions/{institution}/admins', [SuperAdminController::class, 'storeAdmin'])->name('superadmin.admins.store');
    Route::delete('/admins/{user}', [SuperAdminController::class, 'destroyAdmin'])->name('superadmin.admins.destroy');
});