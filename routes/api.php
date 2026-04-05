<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;

// Route Publik
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route Terproteksi (Wajib ada Token JWT untuk BISA MEMBACA DATA / GET)
Route::middleware('jwt.verify')->group(function () {

    // Auth & Profile
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile.show');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Route Custom untuk Dropdown Guru
    Route::get('/users/available-for-guru', [UserController::class, 'getAvailableForGuru']);

    // Safe Methods (GET) - Wajib Login agar HATEOAS $request->user() bisa mendeteksi siapa yang akses
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::apiResource('users', UserController::class)->only(['index', 'show']);
    Route::apiResource('/kelas', KelasController::class)->only(['index', 'show']);
    Route::apiResource('/mapel', MapelController::class)->only(['index', 'show']);
    Route::apiResource('/guru', GuruController::class)->only(['index', 'show']);
    Route::apiResource('/jadwal', JadwalController::class)->only(['index', 'show']);
    Route::apiResource('/siswa', SiswaController::class)->only(['index', 'show']);

    // Route Terproteksi Khusus Admin (Wajib Token + Role Admin) untuk Unsafe Methods (POST, PUT, DELETE)
    Route::middleware('admin')->group(function () {
        Route::apiResource('users', UserController::class)->except(['index', 'show']);
        Route::apiResource('/kelas', KelasController::class)->except(['index', 'show']);
        Route::apiResource('/mapel', MapelController::class)->except(['index', 'show']);
        Route::apiResource('/guru', GuruController::class)->except(['index', 'show']);
        Route::apiResource('/jadwal', JadwalController::class)->except(['index', 'show']);
        Route::apiResource('/siswa', SiswaController::class)->except(['index', 'show']);
    });
});
