<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicArticleController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\JadwalController;
// New separated admin controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\VisionMissionController as AdminVisionMissionController;
use App\Http\Controllers\Admin\AdminManagementController;

// Model imports for route binding
use App\Models\BiodataPengurus;

// Route Model Bindings
Route::bind('pengurus', function ($value) {
    return BiodataPengurus::findOrFail($value);
});

Route::get('/', function () {
    return view('landing-page');
});

// Service Display Routes
Route::get('/staff', [UserController::class, 'staffDisplay'])->name('staff');
Route::get('/lab-rental', [UserController::class, 'labEquipmentDisplay'])->name('lab-rental');
Route::get('/lab-visit', [UserController::class, 'labVisitDisplay'])->name('lab-visit');
Route::get('/vision-mission', [UserController::class, 'getLatestVisionMission'])->name('vision-mission.latest');

// Article Routes (Public)
Route::get('/artikel', [PublicArticleController::class, 'index'])->name('article.index');
Route::get('/artikel/{id}', [PublicArticleController::class, 'show'])->name('article.show');

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
    Route::get('/available-sessions', [JadwalController::class, 'getAvailableSessions'])->name('available-sessions');
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
    
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Equipment Management Routes - Now using dedicated controller
    Route::prefix('admin/equipment')->name('admin.equipment.')->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('index');
        Route::post('/', [EquipmentController::class, 'store'])->name('store');
        Route::put('/{alat}', [EquipmentController::class, 'update'])->name('update');
        Route::delete('/{alat}', [EquipmentController::class, 'destroy'])->name('destroy');
        Route::post('/category', [EquipmentController::class, 'categoryStore'])->name('category.store');
        Route::put('/category/{kategori}', [EquipmentController::class, 'categoryUpdate'])->name('category.update');
        Route::delete('/category/{kategori}', [EquipmentController::class, 'categoryDestroy'])->name('category.destroy');
    });
    
    // Legacy routes for backward compatibility
    Route::get('/admin/alat', function() {
        return redirect()->route('admin.dashboard');
    })->name('admin.alat.index');
    Route::post('/admin/alat', [EquipmentController::class, 'store'])->name('admin.alat.store');
    Route::put('/admin/alat/{alat}', [EquipmentController::class, 'update'])->name('admin.alat.update');
    Route::delete('/admin/alat/{alat}', [EquipmentController::class, 'destroy'])->name('admin.alat.destroy');
    
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
    
    // Staff Management Routes - Now using dedicated controller
    Route::prefix('admin/staff')->name('admin.staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::post('/', [StaffController::class, 'store'])->name('store');
        Route::get('/{staff}', [StaffController::class, 'show'])->name('show');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('update');
        Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('destroy');
    });
    
    // Legacy routes for backward compatibility
    Route::post('/admin/pengurus', [StaffController::class, 'store'])->name('admin.pengurus.store');
    Route::get('/admin/pengurus/{pengurus}/edit', [StaffController::class, 'edit'])->name('admin.pengurus.edit');
    Route::put('/admin/pengurus/{pengurus}', [StaffController::class, 'update'])->name('admin.pengurus.update');
    Route::delete('/admin/pengurus/{pengurus}', [StaffController::class, 'destroy'])->name('admin.pengurus.destroy');
    
    // Vision Mission Management Routes - Now using dedicated controller
    Route::prefix('admin/vision-mission')->name('admin.vision-mission.')->group(function () {
        Route::get('/', [AdminVisionMissionController::class, 'index'])->name('index');
        Route::post('/', [AdminVisionMissionController::class, 'store'])->name('store');
        Route::get('/{visionMission}', [AdminVisionMissionController::class, 'show'])->name('show');
        Route::get('/{visionMission}/edit', [AdminVisionMissionController::class, 'edit'])->name('edit');
        Route::put('/{visionMission}', [AdminVisionMissionController::class, 'update'])->name('update');
        Route::delete('/{visionMission}', [AdminVisionMissionController::class, 'destroy'])->name('destroy');
    });
    
    // Article Management Routes - Now using dedicated admin controller
    Route::prefix('admin/articles')->name('admin.articles.')->group(function () {
        Route::get('/', [AdminArticleController::class, 'index'])->name('index');
        Route::get('/create', [AdminArticleController::class, 'create'])->name('create');
        Route::post('/', [AdminArticleController::class, 'store'])->name('store');
        Route::get('/{article}', [AdminArticleController::class, 'show'])->name('show');
        Route::get('/{article}/edit', [AdminArticleController::class, 'edit'])->name('edit');
        Route::put('/{article}', [AdminArticleController::class, 'update'])->name('update');
        Route::delete('/{article}', [AdminArticleController::class, 'destroy'])->name('destroy');
        Route::delete('/image/{gambar}', [AdminArticleController::class, 'deleteImage'])->name('delete-image');
    });
    
    // Legacy routes for backward compatibility
    Route::prefix('admin/artikel')->name('admin.artikel.')->group(function () {
        Route::get('/', function() { return redirect()->route('admin.dashboard'); })->name('index');
        Route::get('/create', function() { return redirect()->route('admin.dashboard'); })->name('create');
        Route::post('/', [AdminArticleController::class, 'store'])->name('store');
        Route::get('/{artikel}', function() { return redirect()->route('admin.dashboard'); })->name('show');
        Route::get('/{artikel}/edit', function() { return redirect()->route('admin.dashboard'); })->name('edit');
        Route::put('/{artikel}', [AdminArticleController::class, 'update'])->name('update');
        Route::delete('/{artikel}', [AdminArticleController::class, 'destroy'])->name('destroy');
    });
    
    // Gallery Management Routes - Now using dedicated controller
    Route::prefix('admin/gallery')->name('admin.gallery.')->group(function () {
        Route::get('/', [AdminGalleryController::class, 'index'])->name('index');
        Route::post('/', [AdminGalleryController::class, 'store'])->name('store');
        Route::get('/{gambar}', [AdminGalleryController::class, 'show'])->name('show');
        Route::get('/{gambar}/edit', [AdminGalleryController::class, 'edit'])->name('edit');
        Route::put('/{gambar}', [AdminGalleryController::class, 'update'])->name('update');
        Route::delete('/{gambar}', [AdminGalleryController::class, 'destroy'])->name('destroy');
        Route::post('/{gambar}/toggle-visibility', [AdminGalleryController::class, 'toggleVisibility'])->name('toggle-visibility');
    });
    
    // Legacy gallery routes for backward compatibility
    Route::prefix('admin/galeri')->name('admin.galeri.')->group(function () {
        Route::get('/', function() { return redirect()->route('admin.dashboard'); })->name('index');
        Route::post('/', [AdminGalleryController::class, 'store'])->name('store');
        Route::get('/{gambar}/edit', [AdminGalleryController::class, 'edit'])->name('edit');
        Route::post('/{gambar}', [AdminGalleryController::class, 'update'])->name('update');
        Route::put('/{gambar}', [AdminGalleryController::class, 'update'])->name('update-put');
        Route::delete('/{gambar}', [AdminGalleryController::class, 'destroy'])->name('destroy');
        Route::post('/{gambar}/toggle-visibility', [AdminGalleryController::class, 'toggleVisibility'])->name('toggle-visibility');
    });

    // Admin Management Routes - Now using dedicated controller (Only for Super Admin)
    Route::prefix('admin/admin-management')->name('admin.admin-management.')->group(function () {
        Route::get('/', [AdminManagementController::class, 'index'])->name('index');
        Route::post('/', [AdminManagementController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminManagementController::class, 'show'])->name('show');
        Route::get('/{admin}/edit', [AdminManagementController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminManagementController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminManagementController::class, 'destroy'])->name('destroy');
        Route::post('/{admin}/reset-password', [AdminManagementController::class, 'resetPassword'])->name('reset-password');
    });
    
    // Legacy admin management routes for backward compatibility
    Route::middleware(['super_admin'])->prefix('admin/admins')->name('admin.admins.')->group(function () {
        Route::post('/', [AdminManagementController::class, 'store'])->name('store');
        Route::put('/{admin}', [AdminManagementController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminManagementController::class, 'destroy'])->name('destroy');
    });
});
