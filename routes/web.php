<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.dashboard');
});



Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/mahasiswa',[MahasiswaController::class, 'index']);

Route::get('/dosen',[DosenController::class, 'index']);
Route::get('/dosen/create',[DosenController::class, 'create']);
Route::post('/dosen/store',[DosenController::class, 'store']);
Route::get('/dosen/edit/{nidn}',[DosenController::class, 'edit']);
Route::put('/dosen/update',[DosenController::class, 'update']);
Route::delete('/dosen/delete/{nidn}',[DosenController::class, 'destroy']);
