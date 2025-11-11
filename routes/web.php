<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard - accessible by all authenticated users
    Route::get('/dashboard', [AttendanceController::class, 'dashboard'])->name('dashboard');
    
    // Attendance routes
    Route::post('/attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    
    // Admin routes
    Route::get('/attendance/search', [AttendanceController::class, 'search'])->name('attendance.search');
    Route::post('/attendance/pdf', [AttendanceController::class, 'generatePDF'])->name('attendance.pdf');
    
    // Super Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/management', [AdminController::class, 'index'])->name('management');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
    });
});