<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Route default ke welcome page
Route::get('/', function () {
    return view('welcome');
});

// Daftarkan middleware 'web' ke semua route
Route::middleware(['web'])->group(function () {
    // Route ke home
    Route::get('home/index', [HomeController::class, 'index']);
    Route::post('home/post_aksi_e_setting', [HomeController::class, 'post_aksi_e_setting']);

     // Tambahkan route untuk tampil jadwal
     Route::get('home/jadwal', [HomeController::class, 'jadwal']);
    
     // Tambahkan route untuk mendapatkan data jadwal dengan metode POST
     Route::post('home/getJadwal', [HomeController::class, 'getJadwal'])->name('jadwal.getjadwal');
    
     
     // Tambahkan route untuk menghapus jadwal dengan metode POST
     Route::post('home/hapus_jadwal', [HomeController::class, 'hapus_jadwal'])->name('jadwal.hapus');

    //  Route::post('/jadwal/hapus', [HomeController::class, 'hapusJadwal'])->name('jadwal.hapus');
    
});