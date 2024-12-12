<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EcardsController;

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
    return view('welcome');
});

Route::post('getEcard', [EcardsController::class, 'getEcard'])->name('getEcard');
Route::post('addEcard', [EcardsController::class, 'addEcard'])->name('addEcard');
Route::post('storeEcard', [EcardsController::class, 'storeEcard'])->name('storeEcard');
Route::get('ecard/{id}/show', [EcardsController::class, 'show'])->name('show');
Route::put('updateEcard', [EcardsController::class, 'updateEcard'])->name('updateEcard');
