<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth', 'prefix' => 'reports'],  function () {
    Route::get('/', [ReportController::class,'profileReports'])->name('reports.profile');
    Route::get('/export', [ReportController::class,'commonExport'])->name('reports.export');
});