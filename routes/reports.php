<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth', 'prefix' => 'reports'],  function () {
    Route::get('/export', [ReportController::class, 'commonExport'])->name('reports.export');
    Route::get('/attendance/export', [ReportController::class, 'attendance_export'])->name('reports.attendance.export');
});

Route::group(['middleware' => 'auth', 'prefix' => 'reports', 'is_menu' => true],  function () {
    Route::get('/profile', [ReportController::class, 'profileReports'])->name('reports.profile');
    Route::get('/attendance', [ReportController::class, 'attendance_index'])->name('reports.attendance');
});