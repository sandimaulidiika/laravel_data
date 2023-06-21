<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/proses', [AuthController::class, 'proses'])->name('proses');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::get('/user', [HomeController::class, 'user'])->name('user');
Route::get('/create', [HomeController::class, 'create'])->name('user.create');
Route::post('/store', [HomeController::class, 'store'])->name('user.store');

Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
Route::put('/update/{id}', [HomeController::class, 'update'])->name('user.update');
Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('user.delete');
