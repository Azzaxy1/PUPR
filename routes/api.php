<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserDetailController;
use App\Http\Controllers\Api\PengaduanController;
use App\Http\Controllers\Api\PetugasController;
use App\Http\Controllers\Api\PemohonController;
use App\Http\Controllers\Api\CodeController;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa login)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Hanya untuk user yang sudah login via Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    // 🔐 Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Update User
    Route::put('/user/{id}/update', [PetugasController::class, 'updateUser']);
    // Delete User
    Route::delete('/user/{id}/delete', [PetugasController::class, 'deleteUser']);

    // 👤 Profil (lihat, simpan, update)
    Route::get('/profile',    [UserDetailController::class, 'show']);
    Route::post('/profile',   [UserDetailController::class, 'store']);   // jika belum ada
    Route::put('/profile',    [UserDetailController::class, 'update']);  // jika sudah ada

    // 📄 Generate kode (jika ingin uji endpoint CodeController)
    Route::get('/generate-code', [CodeController::class, 'generate']);

    // 📬 Pengaduan
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update']); // Pemohon Update jika masih 0 ( Not Aktif )
    Route::post('/pengaduan',                [PengaduanController::class, 'store']);   // Pemohon
    Route::get('/pengaduan',                 [PengaduanController::class, 'view']);    // Semua role
    Route::post('/pengaduan/{id}/approve',   [PengaduanController::class, 'approve']); // Petugas, UKI, Bidang, BBWS

    // Detail Pengaduan
    Route::get('/pengaduan/{id}/detail', [PemohonController::class, 'detailPengaduan']);

    // Final report
    Route::get('/report/{id}/final', [PetugasController::class, 'final']);

    // History report
    Route::get('/reports/history', [PengaduanController::class, 'history']); // Semua Role
});
