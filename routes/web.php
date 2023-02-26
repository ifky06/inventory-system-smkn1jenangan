<?php

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

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function(){
    // Route::get('dashboard', function () {
    //     return view('dashboard.view');
    // })->name('dashboard');
    Route::get('dashboard',[App\Http\Controllers\HomeController::class,'index']);

    Route::get('export_excel/barang', [App\Http\Controllers\itemController::class,'exportExcel']);
    Route::get('export_excel/barang/{id}', [App\Http\Controllers\itemController::class,'exportExcelBarang']);
    Route::post('export_excel/keluar', [App\Http\Controllers\KeluarMasukController::class,'exportExcelKeluar']);
    Route::post('export_excel/masuk', [App\Http\Controllers\KeluarMasukController::class,'exportExcelMasuk']);
    Route::post('export_excel/datapeminjaman', [App\Http\Controllers\PinjamController::class,'exportExcel']);
    Route::post('export_excel/dataperbaikan', [App\Http\Controllers\RusakController::class,'exportExcel']);
    

    // Route::get('export_pdf/barang', [App\Http\Controllers\itemController::class,'exportPDF']);
    // Route::post('export_pdf/keluar', [App\Http\Controllers\KeluarMasukController::class,'exportPDFKeluar']);
    // Route::post('export_pdf/masuk', [App\Http\Controllers\KeluarMasukController::class,'exportPDFMasuk']);
    // Route::post('export_pdf/datapeminjaman', [App\Http\Controllers\PinjamController::class,'exportPDF']);
    // Route::post('export_pdf/dataperbaikan', [App\Http\Controllers\RusakController::class,'exportPDF']);
    Route::get('export_pdf/detailperbaikan/{id}', [App\Http\Controllers\RusakController::class,'exportPDFdetail']);
    Route::get('export_pdf/detail_barang/{id}', [App\Http\Controllers\ItemController::class,'exportPDFdetailbarang']);
    Route::get('export_pdf/detailpeminjaman/{kode}', [App\Http\Controllers\PinjamController::class,'exportPDFdetail']);


    Route::resource('barang', App\Http\Controllers\itemController::class);
    Route::get('barang/detail_barang/{id}', [App\Http\Controllers\itemController::class,'detailBarang']);
    


    
    Route::get('perbaikan',[App\Http\Controllers\RusakController::class,'tunggu']);
    Route::get('perbaikan/detail/{id}',[App\Http\Controllers\RusakController::class,'detail']);
    Route::post('perbaikan/detail/{id}',[App\Http\Controllers\RusakController::class,'setuju']);
    
    Route::get('diperbaiki',[App\Http\Controllers\RusakController::class,'diperbaiki']);
    Route::get('diperbaiki/detail/{id}',[App\Http\Controllers\RusakController::class,'detail2']);
    Route::post('diperbaiki/detail/{id}',[App\Http\Controllers\RusakController::class,'selesai']);
    
    Route::get('dataperbaikan',[App\Http\Controllers\RusakController::class,'dataIndex']);
    Route::get('dataperbaikan/detail/{id}',[App\Http\Controllers\RusakController::class,'detail3']);

    Route::get('profile',[App\Http\Controllers\profileController::class,'index']);
    Route::get('profile/username',[App\Http\Controllers\profileController::class,'username']);
    Route::post('profile/username',[App\Http\Controllers\profileController::class,'usernameEdit']);
    Route::get('profile/password',[App\Http\Controllers\profileController::class,'password']);
    Route::post('profile/password',[App\Http\Controllers\profileController::class,'passwordEdit']);
    Route::get('profile/edit',[App\Http\Controllers\profileController::class,'editForm']);
    Route::post('profile/edit',[App\Http\Controllers\profileController::class,'edit']);
    
    Route::get('peminjaman', function () {
        return view('peminjaman.view');
    });
    Route::post('peminjaman',[App\Http\Controllers\PinjamController::class,'input']);
    Route::get('/peminjaman/{nama}',[App\Http\Controllers\PinjamController::class,'index']);
    Route::post('/peminjaman/{nama}',[App\Http\Controllers\PinjamController::class,'store']);
    Route::delete('/peminjaman/{id}',[App\Http\Controllers\PinjamController::class,'delete']);
    Route::post('/inputpeminjaman/{nama}',[App\Http\Controllers\PinjamController::class,'inputPinjam']);
    
    Route::get('pengembalian', function () {
        return view('pengembalian.cari');
    });
    Route::get('pengembalian/{kode}',[App\Http\Controllers\PinjamController::class,'kembaliIndex']);
    Route::post('pengembalian',[App\Http\Controllers\PinjamController::class,'cariKode']);
    Route::get('/kembali/{id}',[App\Http\Controllers\PinjamController::class,'kembali']);

    Route::get('datapeminjaman',[App\Http\Controllers\PinjamController::class,'dataIndex']);
    Route::get('datapeminjaman/{kode}',[App\Http\Controllers\PinjamController::class,'dataDetail']);

    Route::get('masuk',[App\Http\Controllers\KeluarMasukController::class,'masuk']);
    Route::get('keluar',[App\Http\Controllers\KeluarMasukController::class,'keluar']);


    Route::middleware(['pj'])->group(function(){
        Route::get('kondisi',[App\Http\Controllers\KondisiController::class,'index']);
        Route::post('kondisi/{id}',[App\Http\Controllers\KondisiController::class,'baik']);
        Route::put('kondisi/{id}',[App\Http\Controllers\KondisiController::class,'rusak']);

        Route::get('rusak',[App\Http\Controllers\RusakController::class,'index']);
        Route::post('rusak/{id}',[App\Http\Controllers\RusakController::class,'store']);
        Route::post('rusak/semua',[App\Http\Controllers\RusakController::class,'storeAll']);
    });

    Route::middleware(['admin'])->group(function(){
        Route::get('barang/detail/{id}', [App\Http\Controllers\itemController::class,'detail']);
        

        Route::resource('sumber_dana', App\Http\Controllers\fundController::class);
        Route::resource('bengkel', App\Http\Controllers\bengkelController::class);



        // Route::get('peminjaman',[App\Http\Controllers\ListPinjamController::class,'index']);

        Route::get('user_admin',[App\Http\Controllers\UserController::class,'adminIndex']);
        Route::post('user_admin',[App\Http\Controllers\UserController::class,'adminStore']);
        Route::put('user_admin/{id}',[App\Http\Controllers\UserController::class,'adminUpdate']);

        Route::get('user_pj',[App\Http\Controllers\UserController::class,'pjIndex']);
        Route::post('user_pj',[App\Http\Controllers\UserController::class,'pjStore']);
        Route::put('user_pj/{id}',[App\Http\Controllers\UserController::class,'pjUpdate']);
    });
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
