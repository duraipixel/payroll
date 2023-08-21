<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalaryReportController;
use App\Http\Controllers\StaffReportController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth', 'prefix' => 'reports'],  function () {
    Route::get('/export', [ReportController::class, 'commonExport'])->name('reports.export');
    Route::get('/attendance/export', [ReportController::class, 'attendance_export'])->name('reports.attendance.export');
    Route::get('/staff/export', [StaffReportController::class, 'staff_export'])->name('reports.staff.export');
    Route::get('/service/history/export', [ReportController::class, 'serviceHistoryExport'])->name('reports.service.history.export');

    // Route::get('/salary-register', [SalaryReportController::class, 'staff_register'])->name('reports.salary.history');
    Route::get('/salary-register/export', [SalaryReportController::class, 'salary_register_export'])->name('reports.salary.export');
});

Route::group(['middleware' => 'auth', 'prefix' => 'reports', 'is_menu' => true],  function () {
    Route::get('/profile', [ReportController::class, 'profileReports'])->name('reports.profile');
    Route::get('/attendance', [ReportController::class, 'attendance_index'])->name('reports.attendance');
    Route::get('/service/history', [ReportController::class, 'serviceHistoryIndex'])->name('reports.service.history');
    Route::get('/staff', [StaffReportController::class, 'staff_history'])->name('reports.staff.history');
    Route::get('/salary-register', [SalaryReportController::class, 'salary_register'])->name('reports.salary.register'); 
});