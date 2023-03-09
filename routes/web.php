<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.template');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/open/modal', [App\Http\Controllers\CommonController::class, 'openAddModal'])->name('modal.open');

Route::post('/save/institution', [App\Http\Controllers\Master\InstitutionController::class, 'save'])->name('save.institute');
Route::post('/get/institution/staff/code', [App\Http\Controllers\Master\InstitutionController::class, 'getInstituteStaffCode'])->name('institute.staff.code');

Route::post('/save/division', [App\Http\Controllers\Master\DivisionController::class, 'save'])->name('save.division');
Route::post('/save/class', [App\Http\Controllers\Master\ClassesController::class, 'save'])->name('save.class');

Route::get('staff/register/{id?}', [App\Http\Controllers\StaffController::class, 'register'])->name('staff.register');
Route::post('staff/add/personal', [App\Http\Controllers\StaffController::class, 'insertPersonalData'])->name('staff.save.personal');
Route::post('staff/get/draftData', [App\Http\Controllers\StaffController::class, 'getStaffDraftData'])->name('staff.get.draft.data');
