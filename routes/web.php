<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EntrieController;
use App\Http\Controllers\OutGoingController;
use App\Http\Controllers\ProfileController;
use App\Mail\newLaravelTips;

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


Route::get('/', [HomeController::class, 'index']);

Route::prefix('painel')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate'])->name('authenticate');

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('registrando');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
    Route::put('profile', [ProfileController::class, 'update'])->name('profileUpdate')->middleware('auth');

    Route::prefix('entries')->group(function () {
        Route::get('/', [EntrieController::class, 'index'])->name('entriesIndex')->middleware('auth');

        Route::get('edit/{id}', [EntrieController::class, 'edit'])->name('entriesEdit')->middleware('auth');
        Route::put('edit/{id}', [EntrieController::class, 'update'])->name('entriesUpdate')->middleware('auth');
        Route::get('create', [EntrieController::class, 'create'])->name('entriesCreate')->middleware('auth');
        Route::post('create', [EntrieController::class, 'store'])->name('entriesStore')->middleware('auth');
        Route::get('search', [EntrieController::class, 'search'])->name('entriesSearch')->middleware('auth');
        Route::post('search_category', [EntrieController::class, 'searchCategory'])->name('entriesSearchCategory')->middleware('auth');
        Route::delete('destroy/{id}', [EntrieController::class, 'destroy'])->name('entriesDestroy')->middleware('auth');
    });

    Route::prefix('outgoing')->group(function () {
        Route::get('/', [OutGoingController::class, 'index'])->name('outgoingsIndex')->middleware('auth');

        Route::get('edit/{id}', [OutGoingController::class, 'edit'])->name('outgoingsEdit')->middleware('auth');
        Route::put('edit/{id}', [OutGoingController::class, 'update'])->name('outgoingsUpdate')->middleware('auth');
        Route::put('pay/{id}', [OutGoingController::class, 'pay'])->name('outgoingsPay')->middleware('auth');
        Route::get('create', [OutGoingController::class, 'create'])->name('outgoingsCreate')->middleware('auth');
        Route::post('create', [OutGoingController::class, 'store'])->name('outgoingsStore')->middleware('auth');
        Route::get('search', [OutGoingController::class, 'search'])->name('outgoingsSearch')->middleware('auth');
        Route::post('search_category', [OutGoingController::class, 'searchCategory'])->name('outgoingsSearchCategory')->middleware('auth');
        Route::delete('destroy/{id}', [OutGoingController::class, 'destroy'])->name('outgoingsDestroy')->middleware('auth');
    });

    Route::get('envia_email', [newLaravelTips::class, 'build'])->name('envEmail')->middleware('auth');
    
});

