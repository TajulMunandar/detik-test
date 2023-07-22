<?php

use App\Http\Controllers\bukuController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [bukuController::class, 'index'])->name('buku.index');
Route::post('/', [bukuController::class, 'store'])->name('buku.store');
Route::put('/{id}', [bukuController::class, 'update'])->name('buku.update');
Route::delete('/{id}', [bukuController::class, 'destroy'])->name('buku.destroy');

Route::resource('/kategori', kategoriController::class);
Route::resource('/user', userController::class);

