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

Route::get('/', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::get('/user', [HomeController::class, 'user'])->middleware('auth')->name('user');
Route::get('/create', [HomeController::class, 'create'])->middleware('auth')->name('user.create');
Route::post('/store', [HomeController::class, 'store'])->middleware('auth')->name('user.store');

Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
Route::put('/update/{id}', [HomeController::class, 'update'])->name('user.update');
Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('user.delete');
