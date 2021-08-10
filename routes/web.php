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

Route::get('/',[App\Http\Controllers\dashboardController::class,'index'])->name('dashboard');
Route::post('/column/save',[App\Http\Controllers\dashboardController::class,'columnSave'])->name('column.save');
Route::post('/card/save',[App\Http\Controllers\dashboardController::class,'cardSave'])->name('card.save');
Route::patch('/card/update',[App\Http\Controllers\dashboardController::class,'cardUpdate'])->name('card.update');
Route::put('/card/sort',[App\Http\Controllers\dashboardController::class,'cardSort'])->name('card.sort');
Route::put('/card/move/{id}',[App\Http\Controllers\dashboardController::class,'cardMove'])->name('card.move');
Route::get('/db_dump',[App\Http\Controllers\dashboardController::class,'databaseDump'])->name('db.dump');
