<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controllers\Middleware;

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::middleware(['guest'])->group(function () {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login'])->name('aksi.login');
});

Route::get('/home', function () {
    return redirect('/admin');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('page.admin')->middleware('userAkses:Admin');
    Route::get('/admin/profil/edit', [AdminController::class, 'editProfil'])->name('edit.profil')->middleware('userAkses:Admin');
    Route::put('/admin/profil/update', [AdminController::class, 'updateProfil'])->name('aksi.update.profil')->middleware('userAkses:Admin');
    Route::put('/admin/profil/update-password', [AdminController::class, 'updatePasswordProfil'])->name('aksi.update.password.profil');
    Route::get('/admin/daftar_sales', [AdminController::class, 'index2'])->name('daftar.sales')->middleware('userAkses:Admin');
    Route::get('/admin/tambah_sales', [AdminController::class, 'index3'])->name('tambah.sales')->middleware('userAkses:Admin');
    Route::post('/admin/tambah_sales', [AdminController::class, 'storeSales'])->name('aksi.tambah.sales')->middleware('userAkses:Admin');
    Route::get('/admin/edit_sales/{id}', [AdminController::class, 'editSales'])->name('edit.sales')->middleware('userAkses:Admin');
    Route::put('/admin/edit_sales/{id}', [AdminController::class, 'updateSales'])->name('aksi.edit.sales')->middleware('userAkses:Admin');
    Route::delete('/admin/hapus_sales/{id}', [AdminController::class, 'destroySales'])->name('aksi.hapus.sales')->middleware('userAkses:Admin');

    Route::get('/admin/daftar_outlet', [AdminController::class, 'index4'])->name('daftar.outlet')->middleware('userAkses:Admin');
    Route::get('/admin/tambah_outlet', [AdminController::class, 'index5'])->name('tambah.outlet')->middleware('userAkses:Admin');

    Route::post('/admin/tambah_outlet', [AdminController::class, 'storeOutlet'])->name('aksi.tambah.outlet')->middleware('userAkses:Admin');
    Route::post('/check-id-outlet', [AdminController::class, 'checkIdOutlet'])->name('check.id.outlet')->middleware('userAkses:Admin');
    Route::get('/admin/edit_outlet/{id}', [AdminController::class, 'editOutlet'])->name('edit.outlet')->middleware('userAkses:Admin');
    Route::put('/admin/edit_outlet/{id}', [AdminController::class, 'updateOutlet'])->name('aksi.edit.outlet')->middleware('userAkses:Admin');
    Route::delete('/admin/hapus_outlet/{id}', [AdminController::class, 'destroyOutlet'])->name('aksi.hapus.outlet')->middleware('userAkses:Admin');

    Route::get('/admin/daftar_tugas', [AdminController::class, 'index6'])->name('daftar.tugas')->middleware('userAkses:Admin');
    Route::get('/admin/tambah_tugas', [AdminController::class, 'index7'])->name('tambah.tugas')->middleware('userAkses:Admin');
    Route::post('/admin/tambah_tugas', [AdminController::class, 'storeTugas'])->name('aksi.tambah.tugas')->middleware('userAkses:Admin');
    Route::get('/admin/lacak_sales/{task}', [AdminController::class, 'index8'])->name('lacak.sales')->middleware('userAkses:Admin');
    /* Route::get('/admin/{sales}/tugas', [AdminController::class, 'showTasks'])->name('lihat.tugas.sales')->middleware('userAkses:Admin');; */
    /* Route::get('/admin/lihat-tugas/{sales_id}', [AdminController::class, 'showTasks'])->name('lihat.tugas.sales'); */
    Route::get('/admin/edit_tugas/{id}', [AdminController::class, 'editTugas'])->name('edit.tugas')->middleware('userAkses:Admin');
    Route::put('/admin/edit_tugas/{id}', [AdminController::class, 'updateTugas'])->name('aksi.edit.tugas')->middleware('userAkses:Admin');

    Route::patch('tasks/{id}/update_status', [AdminController::class, 'updateStatusTugas'])->name('tasks.updateStatus');
    Route::get('/admin/lihat_tugas/{user_id}', [AdminController::class, 'showTasks'])->name('lihat.tugas.user')->middleware('userAkses:Admin');

    Route::get('/sales', [SalesController::class, 'index'])->name('page.sales')->middleware('userAkses:Sales');
    Route::post('/sales/update-location', [SalesController::class, 'storeLocation'])->name('sales.update.location')->middleware('userAkses:Sales');
    /*     Route::get('/sales', [SalesController::class, 'index8'])->name('sales.update.location')->middleware('userAkses:Sales'); */
    Route::get('/sales/daftar_tugas', [SalesController::class, 'index2'])->name('sales.daftar.tugas');
    Route::put('/sales/tugas/{id}/selesai', [SalesController::class, 'selesaiTugas'])->name('tugas.sales.selesai');

    Route::post('/logout', [SesiController::class, 'logout'])->name('aksi.logout');
});
