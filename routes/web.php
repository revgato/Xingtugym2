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
Route::get('/my-gym', [App\Http\Controllers\GymController::class, 'myGym'])->name('my-gym');

// Các route của chủ phòng gym
Route::prefix('/gym')->group(function () {
    Route::get('owner/create', [App\Http\Controllers\GymController::class, 'ownerCreate'])->name('gym.owner.create');
    Route::post('owner/create', [App\Http\Controllers\GymController::class, 'ownerStore'])->name('gym.owner.store');
    Route::get('owner/update', [App\Http\Controllers\GymController::class, 'ownerEdit'])->name('gym.owner.edit');
    Route::post('owner/update', [App\Http\Controllers\GymController::class, 'ownerUpdate'])->name('gym.owner.update');
    Route::get('owner', [App\Http\Controllers\GymController::class, 'ownerShow'])->name('gym.owner.show');
});


Route::prefix('/gym')->group(function () {
    Route::get('/create', [App\Http\Controllers\GymController::class, 'create'])->name('gym.create');
    Route::post('/create', [App\Http\Controllers\GymController::class, 'store'])->name('gym.store');
    Route::get('/update', [App\Http\Controllers\GymController::class, 'edit'])->name('gym.edit');
    Route::post('/update', [App\Http\Controllers\GymController::class, 'update'])->name('gym.update');
    Route::get('/search', [App\Http\Controllers\GymController::class, 'search'])->name('gym.search');
    Route::get('/', [App\Http\Controllers\GymController::class, 'index'])->name('gym.index');
    Route::get('/{id}', [App\Http\Controllers\GymController::class, 'show'])->name('gym.show');
});

