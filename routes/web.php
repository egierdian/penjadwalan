<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\MapelController;

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
    return view('login');
});
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::post('/dashboard/data', [MainController::class, 'data_dashboard']);

    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/post', [UserController::class, 'save']);
    Route::post('/user/post/{id}', [UserController::class, 'save']);
    Route::post('/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/delete/{id}', [UserController::class, 'delete']);

    Route::get('/dosen', [DosenController::class, 'index']);
    Route::post('/dosen/post', [DosenController::class, 'save']);
    Route::post('/dosen/post/{id}', [DosenController::class, 'save']);
    Route::post('/dosen/edit/{id}', [DosenController::class, 'edit']);
    Route::post('/dosen/delete/{id}', [DosenController::class, 'delete']);
    
    Route::get('/ruang', [RuangController::class, 'index']);
    Route::post('/ruang/post', [RuangController::class, 'save']);
    Route::post('/ruang/post/{id}', [RuangController::class, 'save']);
    Route::post('/ruang/edit/{id}', [RuangController::class, 'edit']);
    Route::post('/ruang/delete/{id}', [RuangController::class, 'delete']);
    
    Route::get('/mapel', [MapelController::class, 'index']);
    Route::post('/mapel/post', [MapelController::class, 'save']);
    Route::post('/mapel/post/{id}', [MapelController::class, 'save']);
    Route::post('/mapel/edit/{id}', [MapelController::class, 'edit']);
    Route::post('/mapel/delete/{id}', [MapelController::class, 'delete']);
    
    Route::get('/jadwal', [JadwalController::class, 'index']);
    Route::post('/jadwal/post', [JadwalController::class, 'save']);
    Route::post('/jadwal/post/{id}', [JadwalController::class, 'save']);
    Route::post('/jadwal/edit/{id}', [JadwalController::class, 'edit']);
    Route::post('/jadwal/delete/{id}', [JadwalController::class, 'delete']);
    Route::post('/jadwal/list_dosen', [JadwalController::class, 'listDosen']);
    Route::post('/jadwal/list_ruang', [JadwalController::class, 'listRuang']);
    Route::post('/jadwal/list_mapel', [JadwalController::class, 'listMapel']);

    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});