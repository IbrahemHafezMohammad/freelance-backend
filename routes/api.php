<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\EmployerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('seeker')->group(function () {
    Route::post('/register', [SeekerController::class, 'register']);
    Route::post('/login', [SeekerController::class, 'login']);
});

Route::prefix('employer')->group(function () {
    Route::post('/register', [EmployerController::class, 'register']);
    Route::post('/login', [EmployerController::class, 'login']);
});

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminController::class, 'login']);
});

Route::group(['middleware' => ['auth:sanctum', 'scope.admin', 'whitelist.ip', 'compress.response']], function () {

    Route::prefix('admin')->group(function () { 

        Route::post('/create', [AdminController::class, 'create']);
        Route::put('/edit/{admin}', [AdminController::class, 'edit']);
        Route::get('/create/2fa', [AdminController::class, 'createTwoFactorAuth']);
        Route::post('/2fa/first/check', [AdminController::class, 'firstOTPCheck']);
        Route::post('/disable/2fa', [AdminController::class, 'disableTwoFactorAuth']);
        
        Route::prefix('roles')->group(function () {
            Route::get('/index', [RoleController::class, 'index']);
            Route::post('/store', [RoleController::class, 'store']);
            Route::put('/update/{id}', [RoleController::class, 'update']);
            Route::delete('/delete/{id}', [RoleController::class, 'delete']);
        });
    });
});