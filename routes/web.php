<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IntegrasisystemController;
use App\Http\Controllers\ManifestDomestikController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\OperasionalController;
use App\Http\Controllers\JalurDistribusiController;
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

    Route::controller(OperasionalController::class)->group(function() {
        Route::middleware('hakAkses:admin')->group(function() {
            Route::get('/operasional', 'index');
        });
    });

    Route::controller(ManifestDomestikController::class)->group(function() {
        Route::middleware('hakAkses:admin')->group(function() {
            Route::get('/operasional/manifestdomestik', 'index');
            Route::get('/operasional/manifestdomestik/filter', 'filter')->name('filtermanifestharian');
            Route::get('/operasional/manifestdomestik/tambah', 'tambah');
            Route::post('/operasional/manifestdomestik/save', 'save');
            Route::get('/operasional/manifestdomestik/printresi/{id}', 'printresi');
            Route::get('/operasional/manifestdomestik/hapus/{id}', 'hapus');
            Route::delete('/operasional/manifestdomestik/savehapus', 'savehapus');

            Route::get('/operasional/manifestdomestik/getkota/{id}', 'getKota');
            Route::get('/operasional/manifestdomestik/getKecamatan/{id}', 'getKecamatan');
            Route::get('/operasional/manifestdomestik/resultlayanan', 'resultlayanan')->name('resultlayanan');
            Route::get('/operasional/manifestdomestik/resultitemkhusus', 'resultitemkhusus')->name('resultitemkhusus');
            Route::get('/operasional/manifestdomestik/resulttabelkoli', 'resulttabelkoli')->name('resulttabelkoli');
            Route::get('/operasional/manifestdomestik/resultinformasibiaya', 'resultinformasibiaya')->name('resultinformasibiaya');
            Route::get('/operasional/manifestdomestik/resultjumlahitemkomodit', 'resultjumlahitemkomodit')->name('resultjumlahitemkomodit');
        });
    });

    Route::controller(JalurDistribusiController::class)->group(function () {
        Route::middleware('auth')->group(function() {
            Route::get('/jalurdistribusi', 'index');
        });
    });
});

