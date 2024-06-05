<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IntegrasisystemController;
use App\Http\Controllers\MitraController;
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

Route::middleware(['guest'])->group(function() {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'authenticate']);
});
Route::post('/logout', [LoginController::class, 'logout']);


Route::middleware(('auth'))->group(function () {
    Route::get('/home', function() {
        return redirect('/dashboard');
    });

    Route::controller(DashboardController::class)->group(function() {
        Route::get('/dashboard', 'index');
        Route::get('/dashboard/mainmenu', 'mainmenu');
        Route::get('/dashboard/statistik', 'statistik')->middleware('hakAkses:gm');
    });

    Route::controller(IntegrasisystemController::class)->group(function() {
        Route::middleware('hakAkses:gm')->group(function () {
            Route::get('/integrasisystem', 'index');
        });
    });

    Route::controller(MitraController::class)->group(function() {
        Route::middleware('hakAkses:gm')->group(function() {
            Route::get('integrasisystem/mitra', 'index');
            Route::get('integrasisystem/mitra/show/{id}', 'show');
            Route::get('integrasisystem/mitra/tambah', 'tambah');
            Route::post('integrasisystem/mitra/save', 'save');
            Route::delete('integrasisystem/mitra/hapus', 'hapus');
            Route::get('integrasisystem/mitra/resulttipe', 'resulttipe')->name('resulttipe');
        });
    });
});

