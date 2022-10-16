<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationsController;
use App\Http\Controllers\PermitionsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\CheckupController;
use App\Http\Controllers\PatientsController;

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

Route::get('/', [AuthController::class, 'login'])->name("login");
Route::group(['prefix' => '/auth'], function() {
    Route::get('/', [AuthController::class, 'login'])->name("login");
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout/{id?}', [AuthController::class, 'logout'])->name("logout");
});

Route::group(['prefix' => '/'], function() {
    Route::resource('/home', DashboardController::class);
    Route::resource('regions', RegionsController::class);
    Route::resource('menu', NavigationsController::class)->except("show");
    Route::get('menu/down/{id}', [NavigationsController::class, 'down']);
    Route::get('menu/up/{id}', [NavigationsController::class, 'up']);
    Route::resource('roles', RoleController::class);
    Route::resource('permition', PermitionsController::class);
    Route::resource('user', UserController::class);
    Route::resource('medicine', MedicineController::class);
    Route::resource('checkup', CheckupController::class);
    Route::resource('staff', StaffController::class);
    Route::put('staff/{id}/changestatus', [StaffController::class, 'changestatus']);
    Route::resource('/patient', PatientsController::class);
});