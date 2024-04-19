<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IntegrasisystemController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('home');
Route::get('/dashboard/ruangkerja', [DashboardController::class, 'ruangkerja'])->middleware('auth');

Route::get('/integrasisystem', [IntegrasisystemController::class, 'index']);
Route::get('/integrasisystem/mitra', [IntegrasisystemController::class, 'mitra']);
Route::get('/integrasisystem/mitra/tambahmitra', [IntegrasisystemController::class, 'tambahmitra']);
Route::get('/integrasisystem/mitra/resulttipe', [IntegrasisystemController::class, 'resulttipe'])->name('resulttipe');
Route::post('/integrasisystem/mitra/store', [IntegrasisystemController::class, 'store']);

