<?php

use App\Http\Controllers\ArsipManifestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IntegrasisystemController;
use App\Http\Controllers\ManifestDomestikController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\OperasionalController;
use App\Http\Controllers\JalurDistribusiController;
use App\Http\Controllers\KecamatanController, App\Http\Controllers\OutletController;
use App\Http\Controllers\KelolaAkunController;
use App\Http\Controllers\ManifestInternationalController;
use App\Http\Controllers\VoidManifestController;
use App\Http\Controllers\TrackingController;
use App\Models\VoidManifest;
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
        Route::get('/dashboard/statistik', 'statistik')->middleware('hakAkses:gm');
        Route::middleware('auth')->group(function() {
            Route::get('/dashboard/mainmenu', 'mainmenu');
            Route::get('dashboard/mainmenu/resulttonaseharian', 'resulttonaseharian')->name('resulttonaseharian');
        });
    });

    Route::controller(IntegrasisystemController::class)->group(function() {
        Route::middleware('hakAkses:gm,master')->group(function () {
            Route::get('/integrasisystem', 'index');
        });
    });

    Route::controller(MitraController::class)->group(function() {
        Route::middleware('hakAkses:gm')->group(function() {
            Route::get('integrasisystem/mitra', 'index');
            Route::get('integrasisystem/mitra/detail/{id}', 'detail');
            Route::get('integrasisystem/mitra/tambah', 'tambah');
            Route::post('integrasisystem/mitra/save', 'save');
            Route::delete('integrasisystem/mitra/hapus', 'hapus');
            Route::post('integrasisystem/mitra/update', 'update');
            Route::get('integrasisystem/mitra/resulttipe', 'resulttipe')->name('resulttipe');
            Route::get('integrasisystem/mitra/tambahoutlet/{id}', 'tambahoutlet');
            Route::post('integrasisystem/mitra/saveoutlet', 'saveoutlet');
            Route::post('integrasisystem/mitra/updateoutlet', 'updateoutlet');
            Route::get('integrasisystem/mitra/hapusoutlet/{id}', 'hapusoutlet');
        });
    });

    Route::controller(KelolaAkunController::class)->group(function() {
        Route::middleware('hakAkses:gm')->group(function() {
            Route::get('integrasisystem/kelolaakun', 'index')->name('integrasisystem.kelolaakun');
            Route::get('integrasisystem/kelolaakun/tambah', 'tambah');
            Route::post('integrasisystem/kelolaakun/save', 'save');
            Route::delete('integrasisystem/kelolaakun/hapus', 'hapus');
        });
    });

    Route::controller(OperasionalController::class)->group(function() {
        Route::middleware('hakAkses:master,admin')->group(function() {
            Route::get('/operasional', 'index');
            Route::get('/operasional/cekongkir', 'cekongkir');
            Route::get('operasional/cekongkir/resultcekongkir', 'resultcekongkir')->name('resultcekongkir');
        });
    });

    Route::controller(ManifestDomestikController::class)->group(function() {
        Route::middleware('hakAkses:gm,master,admin')->group(function() {
            Route::delete('/operasional/manifestdomestik/delete', 'delete');
        });

        Route::middleware('hakAkses:master,admin')->group(function() {
            Route::get('/operasional/manifestdomestik', 'index');
            Route::get('/operasional/manifestdomestik/filter', 'filter')->name('filtermanifestharian');
            Route::get('/operasional/manifestdomestik/tambah', 'tambah');
            Route::post('/operasional/manifestdomestik/save', 'save');
            Route::get('/operasional/manifestdomestik/getkota/{id}', 'getKota');
            Route::get('/operasional/manifestdomestik/getKecamatan/{id}', 'getKecamatan');
            Route::get('/operasional/manifestdomestik/resultlayanan', 'resultlayanan')->name('resultlayanan');
            Route::get('/operasional/manifestdomestik/resultitemkhusus', 'resultitemkhusus')->name('resultitemkhusus');
            Route::get('/operasional/manifestdomestik/resulttabelkoli', 'resulttabelkoli')->name('resulttabelkoli');
            Route::get('/operasional/manifestdomestik/resultinformasibiaya', 'resultinformasibiaya')->name('resultinformasibiaya');
            Route::get('/operasional/manifestdomestik/resultjumlahitemkomodit', 'resultjumlahitemkomodit')->name('resultjumlahitemkomodit');
        });

        Route::middleware('hakAkses:gm,master,admin')->group(function() {
            Route::get('/operasional/manifestdomestik/printresi/{id}', 'printresi');
        });
    });

    Route::controller(ManifestInternationalController::class)->group(function() {
        Route::middleware('hakAkses:gm,master,admin')->group(function() {
            Route::delete('/operasional/manifestinternational/delete', 'delete');
        });

        Route::middleware('hakAkses:master,admin')->group(function() {
            Route::get('operasional/manifestinternational', 'index');
            Route::get('/operasional/manifestinternational/filter', 'filter')->name('filtermanifestlnharian');
            Route::get('operasional/manifestinternational/tambah', 'tambah');
            Route::post('operasional/manifestinternational/save', 'save');
            Route::get('/operasional/manifestinternational/getkota/{id}', 'getkota');
            Route::get('/operasional/manifestinternational/resultlayananln', 'resultlayananln')->name('resultlayananln');
            Route::get('/operasional/manifestinternational/resulttabelkoliln', 'resulttabelkoliln')->name('resulttabelkoliln');
            Route::get('/operasional/manifestinternational/resultinformasibiayaln', 'resultinformasibiayaln')->name('resultinformasibiayaln');
        });

        Route::middleware('hakAkses:gm,master,admin')->group(function() {
            Route::get('/operasional/manifestinternational/printresi/{id}', 'printresi');
        });
    });

    Route::controller(ArsipManifestController::class)->group(function() {
        Route::middleware('hakAkses:gm,master,admin')->group(function(){
            Route::get('/arsipmanifest', 'index');
            Route::get('/arsipmanifest/manifestdomestik', 'manifestdomestik');
            Route::get('/arsipmanifest/manifestdomestik/filter', 'filtermanifestdomestik')->name('filtermanifestdomestik');
            Route::get('/arsipmanifest/manifestdomestik/detail/{id}', 'detailmanifestdomestik');
            Route::get('/arsipmanifest/manifestdomestik/edit/{id}', 'editmanifestdomestik');
            Route::post('/arsipmanifest/manifestdomestik/update', 'updatemanifestdomestik');
            Route::get('/arsipmanifest/manifestdomestik/pdf', 'pdfmanifestdomestik')->name('pdfmanifestdomestik');
            Route::get('/arsipmanifest/manifestdomestik/excel', 'excelmanifestdomestik')->name('excelmanifestdomestik');

            Route::get('/arsipmanifest/manifestinternational', 'manifestinternational');
            Route::get('/arsipmanifest/manifestinternational/filter', 'filtermanifestinternational')->name('filtermanifestinternational');
            Route::get('/arsipmanifest/manifestinternational/detail/{id}', 'detailmanifestinternational');
            Route::get('/arsipmanifest/manifestinternational/edit/{id}', 'editmanifestinternational');
            Route::post('/arsipmanifest/manifestinternational/update', 'updatemanifestinternational');
            Route::get('/arsipmanifest/manifestinternational/pdf', 'pdfmanifestinternational')->name('pdfmanifestinternational');
            Route::get('/arsipmanifest/manifestinternational/excel', 'excelmanifestinternational')->name('excelmanifestinternational');
        });
    });

    Route::controller(VoidManifestController::class)->group(function() {
        Route::middleware('hakAkses:gm')->group(function() {
            Route::get('/voidmanifest/manifestdomestik', 'manifestdomestik');
            Route::get('/voidmanifest/manifestdomestik/filter', 'filtermanifestdomestik')->name('filtervoidmanifestdomestik');
            Route::get('/voidmanifest/manifestdomestik/restore/{id}', 'restoremanifestdomestik');
            Route::delete('/voidmanifest/manifestdomestik/delete', 'deletemanifestdomestik');

            Route::get('/voidmanifest/manifestinternational', 'manifestinternational');
            Route::get('/voidmanifest/manifestinternational/filter', 'filtermanifestinternational')->name('filtermanifestinternational');
            Route::get('/voidmanifest/manifestinternational/restore/{id}', 'restoremanifestinternational');
            Route::delete('/voidmanifest/manifestinternational/delete', 'deletemanifestinternational');
        });
    });

    Route::controller(JalurDistribusiController::class)->group(function () {
        Route::middleware('hakAkses:admin,master,gm,gudang')->group(function() {
            Route::get('/jalurdistribusi', 'index');
            Route::get('/jalurdistribusi/menuscan', 'menuscan');

            Route::get('/jalurdistribusi/scanmasuk', 'scanmasuk');
            Route::post('/jalurdistribusi/savescanmasuk', 'savescanmasuk');

            Route::get('/jalurdistribusi/scankirim', 'scankirim');
            Route::post('/jalurdistribusi/savescankirim', 'savescankirim');

            Route::get('jalurdistribusi/scanpaketsampai', 'scanpaketsampai');
            Route::post('jalurdistribusi/savescanpaketsampai', 'savescanpaketsampai');

            Route::get('jalurdistribusi/scankeluar', 'scankeluar');
            Route::post('jalurdistribusi/savescankeluar', 'savescankeluar');

            Route::get('jalurdistribusi/scanttd', 'scanttd');
            Route::post('jalurdistribusi/savescanttd', 'savescanttd');
        });
        Route::middleware('hakAkses:gm,gudang')->group(function() {
            Route::get('/jalurdistribusi/scankarung', 'scankarung');
            Route::post('/jalurdistribusi/savescankarung', 'savescankarung');
            Route::get('jalurdistribusi/editscankarung', 'editscankarung');
            Route::post('jalurdistribusi/updatescankarung', 'updatescankarung');
            Route::get('/jalurdistribusi/hapusscankarung/{no_karung}', 'hapusscankarung');
            Route::get('/jalurdistribusi/searchkodekarung', 'searchkodekarung')->name('searchkodekarung');

            Route::get('/jalurdistribusi/downloadkarungpdf', 'downloadkarungpdf')->name('downloadkarungpdf');

            Route::get('/jalurdistribusi/kirimpaketmuatan', 'kirimpaketmuatan');
            Route::post('/jalurdistribusi/savekirimpaketmuatan', 'savekirimpaketmuatan');
            Route::get('/jalurdistribusi/filterkirimpaketmuatan', 'filterkirimpaketmuatan')->name('filterkirimpaketmuatan');
            Route::get('/jalurdistribusi/searchtujuankirimpaketmuatan', 'searchtujuankirimpaketmuatan')->name('searchtujuankirimpaketmuatan');

            Route::get('jalurdistribusi/bongkarpaketsampai', 'bongkarpaketsampai');
            Route::post('jalurdistribusi/savebongkarpaketsampai', 'savebongkarpaketsampai');
        });
    });

    Route::controller(KecamatanController::class)->group(function() {
        Route::get('searchkecamatan', 'searchkecamatan')->name('searchkecamatan');
    });

    Route::controller(OutletController::class)->group(function() {
        Route::get('searchoutlet', 'searchoutlet')->name('searchoutlet');
    });

    Route::controller(TrackingController::class)->group(function() {
        Route::middleware('auth')->group(function() {
            Route::post('tracking/lacakpaket', 'lacakpaket');
        });
    });
});

