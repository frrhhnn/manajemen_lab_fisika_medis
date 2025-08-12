<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\JadwalController;

Route::get('/', function () {
    return view('landing-page');
});

// Service Display Routes
Route::get('/staff', [UserController::class, 'staffDisplay'])->name('staff');
Route::get('/lab-rental', [UserController::class, 'labEquipmentDisplay'])->name('lab-rental');
Route::get('/lab-visit', [UserController::class, 'labVisitDisplay'])->name('lab-visit');
Route::get('/vision-mission', [UserController::class, 'getLatestVisionMission'])->name('vision-mission.latest');

// Article Routes
Route::get('/artikel', [ArticleController::class, 'index'])->name('article.index');
Route::get('/artikel/{id}', [ArticleController::class, 'show'])->name('article.show');

// Equipment & Lab Services Routes
Route::get('/fasilitas/peminjaman-alat', [UserController::class, 'equipmentRental'])->name('equipment.rental');
Route::get('/fasilitas/peminjaman-alat/{id}', [UserController::class, 'equipmentDetail'])->name('equipment.detail');
Route::get('/fasilitas/kunjungan-lab', [UserController::class, 'labVisit'])->name('lab.visit');

// User Peminjaman Routes (Public)
Route::prefix('peminjaman')->name('user.peminjaman.')->group(function () {
    Route::get('/alat-tersedia', [PeminjamanController::class, 'showAvailable'])->name('available');
    Route::get('/ajukan', [PeminjamanController::class, 'create'])->name('create');
    Route::post('/ajukan', [PeminjamanController::class, 'store'])->name('store');
    Route::get('/{peminjaman}/tracking', [PeminjamanController::class, 'tracking'])->name('tracking');
    Route::get('/{peminjaman}/download-letter', [PeminjamanController::class, 'downloadLetter'])->name('download-letter');
    Route::get('/{peminjaman}', [PeminjamanController::class, 'show'])->name('show');
    Route::get('/riwayat/saya', [PeminjamanController::class, 'userHistory'])->name('history');
});

// User Kunjungan Routes (Public)
Route::prefix('kunjungan')->name('kunjungan.')->group(function () {
    Route::get('/ajukan', [KunjunganController::class, 'create'])->name('create');
    Route::post('/ajukan', [KunjunganController::class, 'store'])->name('store');
    Route::get('/{kunjungan}/tracking', [KunjunganController::class, 'tracking'])->name('tracking');
    Route::patch('/{kunjungan}/cancel', [KunjunganController::class, 'cancel'])->name('cancel');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected by admin middleware)
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });
    
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Alat Management Routes - Integrated with Dashboard
    Route::get('/admin/alat', function() {
        return redirect()->route('admin.dashboard');
    })->name('admin.alat.index'); // Redirect for backward compatibility
    Route::post('/admin/alat', [AdminController::class, 'alatStore'])->name('admin.alat.store');
    Route::put('/admin/alat/{alat}', [AdminController::class, 'alatUpdate'])->name('admin.alat.update');
    Route::delete('/admin/alat/{alat}', [AdminController::class, 'alatDestroy'])->name('admin.alat.destroy');
    
    // Peminjaman Management Routes
    Route::prefix('admin/peminjaman')->name('admin.peminjaman.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/{peminjaman}/detail', [PeminjamanController::class, 'detail'])->name('detail');
        Route::get('/{peminjaman}/items', [PeminjamanController::class, 'items'])->name('items');
        Route::patch('/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('approve');
        Route::patch('/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('reject');
        Route::patch('/{peminjaman}/confirm', [PeminjamanController::class, 'confirm'])->name('confirm');
        Route::post('/{peminjaman}/complete', [PeminjamanController::class, 'complete'])->name('complete');
        Route::post('/{peminjaman}/complete-simple', [PeminjamanController::class, 'completeSimple'])->name('complete-simple');
    });
    
    // Equipment Management Routes - Redirected to Dashboard
    Route::get('/admin/equipment', function() {
        return redirect()->route('admin.dashboard');
    })->name('admin.equipment.index');
    
    // Visit Management Routes
    Route::prefix('admin/kunjungan')->name('admin.kunjungan.')->group(function () {
        Route::get('/', [KunjunganController::class, 'index'])->name('index');
        Route::get('/{kunjungan}', [KunjunganController::class, 'show'])->name('show');
        Route::get('/{kunjungan}/detail', [KunjunganController::class, 'detail'])->name('detail');
        Route::patch('/{kunjungan}/approve', [KunjunganController::class, 'approve'])->name('approve');
        Route::patch('/{kunjungan}/reject', [KunjunganController::class, 'reject'])->name('reject');
        Route::patch('/{kunjungan}/complete', [KunjunganController::class, 'complete'])->name('complete');
    });

    // Schedule Management Routes
    Route::prefix('admin/jadwal')->name('admin.jadwal.')->group(function () {
        Route::get('/', [JadwalController::class, 'index'])->name('index');
        Route::get('/calendar-data', [JadwalController::class, 'getCalendarData'])->name('calendar-data');
        Route::get('/schedule-settings', [JadwalController::class, 'getScheduleSettings'])->name('schedule-settings');
        Route::post('/toggle-availability', [JadwalController::class, 'toggleAvailability'])->name('toggle-availability');
        Route::get('/available-sessions', [JadwalController::class, 'getAvailableSessions'])->name('available-sessions');
        Route::put('/{id}', [JadwalController::class, 'update'])->name('update');
        Route::delete('/{id}', [JadwalController::class, 'destroy'])->name('destroy');
    });
    
    // Staff Management Routes
    Route::get('/admin/staff', function() {
        return redirect()->route('admin.dashboard');
    })->name('admin.staff.index');
    Route::post('/admin/pengurus', [AdminController::class, 'staffStore'])->name('admin.pengurus.store');
    Route::get('/admin/pengurus/{pengurus}/edit', [AdminController::class, 'staffEdit'])->name('admin.pengurus.edit');
    Route::put('/admin/pengurus/{pengurus}', [AdminController::class, 'staffUpdate'])->name('admin.pengurus.update');
    Route::delete('/admin/pengurus/{pengurus}', [AdminController::class, 'staffDestroy'])->name('admin.pengurus.destroy');
    
    // Vision Mission Management Routes
    Route::get('/admin/vision-mission', [AdminController::class, 'visionMissionIndex'])->name('admin.vision-mission.index');
    Route::post('/admin/vision-mission', [AdminController::class, 'visionMissionStore'])->name('admin.vision-mission.store');
    Route::get('/admin/vision-mission/{visionMission}/edit', [AdminController::class, 'visionMissionEdit'])->name('admin.vision-mission.edit');
    Route::put('/admin/vision-mission/{visionMission}', [AdminController::class, 'visionMissionUpdate'])->name('admin.vision-mission.update');
    Route::delete('/admin/vision-mission/{visionMission}', [AdminController::class, 'visionMissionDestroy'])->name('admin.vision-mission.destroy');
    
    // Article Management Routes
    Route::prefix('admin/artikel')->name('admin.artikel.')->group(function () {
        Route::get('/', [AdminController::class, 'artikelIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'artikelCreate'])->name('create');
        Route::post('/', [AdminController::class, 'artikelStore'])->name('store');
        Route::get('/{artikel}', [AdminController::class, 'artikelShow'])->name('show');
        Route::get('/{artikel}/edit', [AdminController::class, 'artikelEdit'])->name('edit');
        Route::put('/{artikel}', [AdminController::class, 'artikelUpdate'])->name('update');
        Route::delete('/{artikel}', [AdminController::class, 'artikelDestroy'])->name('destroy');
    });
    
    // Gallery Management Routes
    Route::prefix('admin/galeri')->name('admin.galeri.')->group(function () {
        Route::get('/', [AdminController::class, 'galeriIndex'])->name('index');
        Route::post('/', [AdminController::class, 'galeriStore'])->name('store');
        Route::get('/{gambar}/edit', [AdminController::class, 'galeriEdit'])->name('edit');
        Route::post('/{gambar}', [AdminController::class, 'galeriUpdate'])->name('update'); // Changed to POST
        Route::put('/{gambar}', [AdminController::class, 'galeriUpdate'])->name('update-put'); // Keep PUT for compatibility
        Route::delete('/{gambar}', [AdminController::class, 'galeriDestroy'])->name('destroy');
        Route::post('/{gambar}/toggle-visibility', [AdminController::class, 'galeriToggleVisibility'])->name('toggle-visibility');
    });

    // Admin Management Routes (Only for Super Admin)
    Route::middleware(['super_admin'])->prefix('admin/admins')->name('admin.admins.')->group(function () {
        Route::post('/', [AdminController::class, 'adminStore'])->name('store');
        Route::put('/{admin}', [AdminController::class, 'adminUpdate'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'adminDestroy'])->name('destroy');
    });
});