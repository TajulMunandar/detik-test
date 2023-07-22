<?php

use App\Http\Controllers\bukuController;
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
Route::get('/', [bukuController::class, 'index'])->name('buku');

Route::get('/kategori', function () {
    return view('dashboardPage.kategori',[
        'page' => "Kategori"
    ]);
});

Route::get('/user', function () {
    return view('dashboardPage.user',[
        'page' => "User"
    ]);
});
