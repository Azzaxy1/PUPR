<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\KetuaUkiController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\KepalaBbwsController;

// Root route: welcome or redirect based on role
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role->title;
        switch ($role) {
            case 'Pemohon':
                return redirect()->route('pemohon.dashboard');
            case 'Petugas Layanan':
                return redirect()->route('petugas.dashboard');
            case 'Ketua UKI':
                return redirect()->route('ketuauki.dashboard');
            case 'Bidang/Satker/SNVT':
                return redirect()->route('bidang.dashboard');
            case 'Kepala BBWS':
                return redirect()->route('kepalabbws.dashboard');
        }
    }
    return view('welcome');
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

// Pemohon Routes
Route::middleware(['role:Pemohon'])->prefix('pemohon')->name('pemohon.')->group(function () {
    Route::get('dashboard', [PemohonController::class, 'dashboard'])->name('dashboard');
    Route::get('dokumen-pendukung/{filename}', function ($filename) {
        $path = storage_path('app/dokumen_pengaduan/' . $filename);

        if (!\Illuminate\Support\Facades\File::exists($path)) {
            abort(404);
        }

        // nama file saat di-download:
        $ext        = pathinfo($filename, PATHINFO_EXTENSION);
        $customName = 'dokumen_pendukung' . request()->segment(3) . '.' . $ext;

        return \Illuminate\Support\Facades\Response::download(
            $path,
            $customName
        );
    })->name('dokumen.pendukung');
    Route::get('profile', [PemohonController::class, 'profile'])->name('profile');
    Route::put('profile', [PemohonController::class, 'updateProfile'])->name('updateProfile');
    Route::get('pengaduan/create', [PemohonController::class, 'showCreate'])->name('create');
    Route::post('pengaduan', [PemohonController::class, 'store'])->name('store');
    Route::get('pengaduan/{id}', [PemohonController::class, 'detail'])->name('detail');
    Route::get('pengaduan/{id}/download', [PemohonController::class, 'downloadPdf'])->name('downloadPdf');
});

// Petugas Layanan Routes
Route::middleware(['auth','role:Petugas Layanan'])->prefix('petugas')->name('petugas.')->group(function () {
    // Dashboard & Profile
    Route::get('dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [PetugasController::class, 'profile'])->name('profile');
    Route::put('profile', [PetugasController::class, 'updateProfile'])->name('profile.update');
    // Manage Users
    Route::get('users', [PetugasController::class, 'usersIndex'])->name('users.index');
    Route::get('users/create', [PetugasController::class, 'createUser'])->name('users.create');
    Route::post('users', [PetugasController::class, 'storeUser'])->name('users.store');
    Route::get('users/{id}/edit', [PetugasController::class, 'editUser'])->name('users.edit');
    Route::put('users/{id}', [PetugasController::class, 'updateUser'])->name('users.update');
    Route::delete('users/{id}', [PetugasController::class, 'deleteUser'])->name('users.destroy');
    // Pengaduan (verifikasi)
    Route::get('pengaduan', [PetugasController::class, 'pengaduanIndex'])->name('pengaduan.index');
    Route::get('pengaduan/{id}/edit', [PetugasController::class, 'pengaduanEdit'])->name('pengaduan.edit');
    Route::put('pengaduan/{id}', [PetugasController::class, 'pengaduanUpdate'])->name('pengaduan.update');
    // Final Reports
    Route::get('final', [PetugasController::class, 'final'])->name('final.index');
    Route::get('final/{id}/pdf', [PetugasController::class, 'finalPdf'])->name('final.pdf');
    // History Transactions
    Route::get('history', [PetugasController::class, 'history'])->name('history.index');
});

// Ketua UKI Routes
Route::middleware(['auth','role:Ketua UKI'])->prefix('ketuauki')->name('ketuauki.')->group(function() {
    // Dashboard & Profile
    Route::get('dashboard', [KetuaUkiController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [KetuaUkiController::class, 'profile'])->name('profile');
    Route::put('profile', [KetuaUkiController::class, 'updateProfile'])->name('profile.update');
    // Pengaduan (verifikasi Ketua UKI)
    Route::get('pengaduan', [KetuaUkiController::class, 'pengaduanIndex'])->name('pengaduan.index');
    Route::get('pengaduan/{id}/edit', [KetuaUkiController::class, 'pengaduanEdit'])->name('pengaduan.edit');
    Route::put('pengaduan/{id}', [KetuaUkiController::class, 'pengaduanUpdate'])->name('pengaduan.update');
    // History Ketua UKI
    Route::get('history', [KetuaUkiController::class, 'history'])->name('history.index');
});

// Bidang/Satker Routes
Route::middleware(['auth','role:Bidang/Satker/SNVT'])->prefix('bidang')->name('bidang.')->group(function() {
    // Dashboard & Profile
    Route::get('dashboard',         [BidangController::class, 'dashboard'])->name('dashboard');
    Route::get('profile',           [BidangController::class, 'profile'])->name('profile');
    Route::put('profile',           [BidangController::class, 'updateProfile'])->name('profile.update');
    // Pengaduan untuk telaah
    Route::get('pengaduan',         [BidangController::class, 'pengaduanIndex'])->name('pengaduan.index');
    Route::get('pengaduan/{report}',[BidangController::class, 'pengaduanEdit'])->name('pengaduan.edit');
    Route::put('pengaduan/{report}',[BidangController::class, 'pengaduanUpdate'])->name('pengaduan.update');
    // History telaah
    Route::get('history',           [BidangController::class, 'history'])->name('history.index');
});

// Kepala BBWS Routes
Route::middleware(['auth','role:Kepala BBWS'])->prefix('kepalabbws')->name('kepalabbws.')->group(function() {
    // Dashboard & Profile
    Route::get('dashboard', [KepalaBbwsController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [KepalaBbwsController::class, 'profile'])->name('profile');
    Route::put('profile', [KepalaBbwsController::class, 'updateProfile'])->name('profile.update');
    // Pengaduan Finalisasi
    Route::get('pengaduan', [KepalaBbwsController::class, 'pengaduanIndex'])->name('pengaduan.index');
    Route::get('pengaduan/{report}/edit', [KepalaBbwsController::class, 'pengaduanEdit'])->name('pengaduan.edit');
    Route::put('pengaduan/{report}', [KepalaBbwsController::class, 'pengaduanUpdate'])->name('pengaduan.update');
    // History Transaksi
    Route::get('history', [KepalaBbwsController::class, 'history'])->name('history.index');
});
