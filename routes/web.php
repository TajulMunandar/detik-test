<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\bukuController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\RegisterController;
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
Route::get('/', [bukuController::class, 'index'])->name('buku.index')->middleware('auth');
Route::post('/', [bukuController::class, 'store'])->name('buku.store')->middleware('auth');
Route::put('/{id}', [bukuController::class, 'update'])->name('buku.update')->middleware('auth');
Route::delete('/{id}', [bukuController::class, 'destroy'])->name('buku.destroy')->middleware('auth');

Route::resource('/kategori', kategoriController::class)->middleware('auth');

Route::resource('/user', userController::class)->middleware('auth');
Route::post('/user/reset-password', [userController::class, 'resetPasswordAdmin'])->name('user.password')->middleware('auth');

Route::controller(authController::class)->group(function () {
    Route::get('/login', 'index')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate');
    Route::post('/logout', 'logout');
});

Route::resource('/register', RegisterController::class)->middleware('guest');
