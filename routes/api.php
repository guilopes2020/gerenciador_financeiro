<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function () {
    return ['pong' => true];
});;

Route::prefix('/auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login'])->name('loginApi');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logoutApi');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refreshApi');
    
});

Route::post('/user', [AuthController::class, 'create'])->name('createe');

Route::get('/user', [UserController::class, 'read'])->name('read');


