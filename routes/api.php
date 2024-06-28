<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
    Route::post('/login', [SeekerController::class,'login']);
});

Route::prefix('employer')->group(function () {
    Route::post('/register', [EmployerController::class, 'register']);
    Route::post('/login', [EmployerController::class,'login']);
});