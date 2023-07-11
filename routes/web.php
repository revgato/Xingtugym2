<?php

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::get('/signup', [App\Http\Controllers\Auth\SignUpController::class, 'showSignUpForm'])->name('signup');
Route::post('/signup', [App\Http\Controllers\Auth\SignUpController::class, 'signup']);

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
// group gym 
Route::get('/my-gym', [App\Http\Controllers\GymController::class, 'index'])->name('my-gym');
Route::prefix('/gym')->group(function () {
    Route::get('/create', [App\Http\Controllers\GymController::class, 'create'])->name('gym.create');
    Route::post('/create', [App\Http\Controllers\GymController::class, 'store'])->name('gym.store');
    Route::get('/update', [App\Http\Controllers\GymController::class, 'edit'])->name('gym.edit');
    Route::post('/update', [App\Http\Controllers\GymController::class, 'update'])->name('gym.update');
    Route::get('/review/{gym}', [App\Http\Controllers\ReviewController::class, 'index'])->name('gym.review');
});

