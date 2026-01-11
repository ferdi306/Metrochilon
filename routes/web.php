<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeManagementController;
use App\Http\Controllers\EmployeeDocumentController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AttendanceSettingController;
use App\Http\Controllers\ProfileController;

Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Password reset
Route::get('/password/reset', [AuthController::class, 'showForgotPassword'])->name('password.request')->middleware('guest');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('guest');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset')->middleware('guest');
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update')->middleware('guest');

// Force change password after admin reset
Route::get('/password/force', [AuthController::class, 'showForceChangePassword'])->name('password.force')->middleware('auth');
Route::post('/password/force', [AuthController::class, 'forceChangePassword'])->name('password.force.update')->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Karyawan area
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/karyawan', [AttendanceController::class, 'dashboard'])->name('karyawan.dashboard');
    Route::get('/karyawan/absen', [AttendanceController::class, 'absenPage'])->name('karyawan.absen');
    Route::post('/absen', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('/loc/ping', [LocationController::class, 'ping']);
    
    // Attendance routes
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    
    // Profile routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Leave routes
    Route::get('/leave', [LeaveController::class, 'create'])->name('leave.create');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
});

// Admin area
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/locations', [AdminController::class, 'locationsPage'])->name('admin.locations.page');
    Route::get('/admin/locations/api', [AdminController::class, 'locations'])->name('admin.locations');
    Route::get('/admin/attendances', [AdminController::class, 'attendancesPage'])->name('admin.attendances.page');
    Route::get('/admin/attendances/api', [AdminController::class, 'attendances'])->name('admin.attendances');
    
    // Employee Management
    Route::resource('admin/employees', EmployeeManagementController::class)->names([
        'index' => 'admin.employees.index',
        'create' => 'admin.employees.create',
        'store' => 'admin.employees.store',
        'show' => 'admin.employees.show',
        'edit' => 'admin.employees.edit',
        'update' => 'admin.employees.update',
        'destroy' => 'admin.employees.destroy',
    ]);

    // Admin: generate temporary password for employee
    Route::post('/admin/employees/{id}/temp-password', [EmployeeManagementController::class, 'setTemporaryPassword'])->name('admin.employees.temp_password');

    // Employee documents
    Route::post('/admin/employees/{id}/documents', [EmployeeDocumentController::class, 'store'])->name('admin.employees.documents.store');
    Route::get('/admin/employees/{id}/documents/{doc}/download', [EmployeeDocumentController::class, 'download'])->name('admin.employees.documents.download');
    Route::delete('/admin/employees/{id}/documents/{doc}', [EmployeeDocumentController::class, 'destroy'])->name('admin.employees.documents.destroy');
    
    // Leave Management
    Route::get('/admin/leaves', [LeaveController::class, 'index'])->name('admin.leaves.index');
    Route::post('/admin/leaves/{id}/approve', [LeaveController::class, 'approve'])->name('admin.leaves.approve');
    Route::post('/admin/leaves/{id}/reject', [LeaveController::class, 'reject'])->name('admin.leaves.reject');
    
    // Attendance Settings
    Route::get('/admin/attendance-settings', [AttendanceSettingController::class, 'index'])->name('admin.attendance-settings.index');
    Route::put('/admin/attendance-settings', [AttendanceSettingController::class, 'update'])->name('admin.attendance-settings.update');

    // Analytics API
    Route::get('/admin/api/analytics/attendance/daily', [AnalyticsController::class, 'attendanceDaily'])->name('admin.api.analytics.attendance.daily');
    Route::get('/admin/api/analytics/attendance/monthly', [AnalyticsController::class, 'attendanceMonthly'])->name('admin.api.analytics.attendance.monthly');

    // Exports (CSV/PDF)
    Route::get('/admin/export/attendance/daily', [AnalyticsController::class, 'exportDailyCsv'])->name('admin.export.attendance.daily');
    Route::get('/admin/export/attendance/monthly', [AnalyticsController::class, 'exportMonthlyCsv'])->name('admin.export.attendance.monthly');
});
