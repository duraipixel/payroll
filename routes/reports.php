<?php

use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RetirementController;
use App\Http\Controllers\SalaryReportController;
use App\Http\Controllers\StaffReportController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth', 'prefix' => 'reports'],  function () {
    Route::get('/export', [ReportController::class, 'commonExport'])->name('reports.export');
    Route::get('/attendance/export', [ReportController::class, 'attendance_export'])->name('reports.attendance.export');
    Route::get('/staff/export', [StaffReportController::class, 'staff_export'])->name('reports.staff.export');
    Route::get('/service/history/export', [ReportController::class, 'serviceHistoryExport'])->name('reports.service.history.export');

    Route::get('/salary-register/export', [SalaryReportController::class, 'salary_register_export'])->name('reports.salary.export');
    Route::get('/reports/retirement/export', [RetirementController::class, 'export'])->name('reports.retirement.export');
    Route::get('/reports/leaves/export', [LeaveController::class, 'export'])->name('reports.leaves.export');
    
});

Route::group(['middleware' => 'auth', 'prefix' => 'reports', 'is_menu' => true],  function () {
    Route::get('/profile', [ReportController::class, 'profileReports'])->name('reports.profile');
    Route::get('/attendance', [ReportController::class, 'attendance_index'])->name('reports.attendance');
    Route::get('/service/history', [ReportController::class, 'serviceHistoryIndex'])->name('reports.service.history');
    Route::get('/staff', [StaffReportController::class, 'staff_history'])->name('reports.staff.history');
    Route::get('/salary-register', [SalaryReportController::class, 'salary_register'])->name('reports.salary.register'); 
    Route::get('/retirement-report', [RetirementController::class, 'index'])->name('reports.retirement'); 
    Route::get('/leaves-report', [LeaveController::class, 'index'])->name('reports.leaves'); 
#....Ajith
    Route::get('/epf-report', [ReportController::class, 'index'])->name('reports.epf.report');
    Route::get('/esi-report', [ReportController::class, 'ESI'])->name('reports.esi.report');
    Route::get('/income-tax-report', [ReportController::class, 'index'])->name('reports.income.tax.report');
    Route::get('/bonus-report', [ReportController::class, 'Bonus'])->name('reports.bonus.report');


    Route::get('/arrears-report', [ReportController::class, 'Arrers'])->name('reports.arrears.report');
    Route::get('/gratutity-report', [ReportController::class, 'index'])->name('reports.gratutity.report');
    Route::get('/resignation-report', [ReportController::class, 'Resigned'])->name('reports.resignation.report');
    Route::get('/staff-leave-report', [ReportController::class, 'index'])->name('reports.staff.leave.report');

    Route::get('/salary-acquitance-report', [ReportController::class, 'index'])->name('reports.salary.acquitance.report');

    Route::get('/staff-acquitance-register-report', [ReportController::class, 'index'])->name('reports.staff.acquitance.register.report');

    Route::get('/bank-disbursement-report', [ReportController::class, 'index'])->name('reports.bank.disbursement.report');

    Route::get('/bank-loan-report', [ReportController::class, 'BankLoanReport'])->name('reports.bank.loan.report');
    Route::get('/personal-loan-report', [ReportController::class, 'index'])->name('reports.personal.loan.report');
   Route::get('/personal-loan-report', [ReportController::class, 'index'])->name('reports.personal.loan.report');
   Route::get('/lic-report', [ReportController::class, 'InsuranceReport'])->name('reports.lic.report');
   Route::get('/lop-report', [ReportController::class, 'LOP'])->name('reports.lop.report');
    Route::get('/salary-hold-report', [ReportController::class, 'SalaryHold'])->name('reports.salary.hold.report');
  Route::get('/professional-tax-report', [ReportController::class, 'index'])->name('reports.professional.tax.report');
    Route::get('/month-wise-variation-report', [ReportController::class, 'index'])->name('reports.month.wise.variation.report');

});