<?php

use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployerController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

//email/verify
Route::get('/email/not/verified', function () {
    Log::info('request in email/verify');
    return response()->json([
        'status' => false,
        'message' => 'EMAIL_NOT_VERIFIED',
    ], 401);
})->middleware('auth:sanctum')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $user = $request->user();
    if (!is_null($user->email_verified_at)) {
        return response()->json(['message' => 'EMAIL_ALREADY_VERIFIED'], 400);
    }
    $user->sendEmailVerificationNotification();

    return response()->json([
        'status' => true,
        'message' => 'EMAIL_VERIFICATION_LINK_SENT',
    ], 200);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::post('/email/verify', [UserController::class, 'verifyEmail'])->middleware(['auth:sanctum'])->name('verification.verify');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/skills/dropdown', [SkillController::class, 'fetch']);
    Route::post('/upload/file', [GeneralController::class, 'uploadFile']);
});

Route::group(['middleware' => ['auth:sanctum', 'scope.seeker']], function () {

    Route::prefix('seeker')->group(function () {
        Route::get('dashboard', [SeekerController::class, 'dashboard']);
        Route::post('/update/{user}', [SeekerController::class, 'update']);

        Route::group(['middleware' => ['verified']], function () {
            Route::prefix('jobs')->group(function () {
                Route::get('/list', [JobPostController::class, 'list']);
            });
        });
    });
});

Route::group(['middleware' => ['auth:sanctum', 'scope.employer']], function () {

    Route::prefix('employer')->group(function () {

        Route::group(['middleware' => ['verified']], function () {

            Route::prefix('jobs')->group(function () {
                Route::post('/post', [JobPostController::class, 'post']);
            });
        });

        Route::get('dashboard', [EmployerController::class, 'dashboard']);
    });
});

Route::group(['middleware' => ['auth:sanctum', 'scope.admin', 'compress.response', 'verified']], function () {

    Route::prefix('admin')->group(function () {

        Route::post('/create', [AdminController::class, 'create']);
        Route::put('/edit/{admin}', [AdminController::class, 'edit']);
        Route::get('/create/2fa', [AdminController::class, 'createTwoFactorAuth']);
        Route::post('/2fa/first/check', [AdminController::class, 'firstOTPCheck']);
        Route::post('/disable/2fa', [AdminController::class, 'disableTwoFactorAuth']);

        Route::prefix('category')->group(function () {
            Route::post('/create', [CategoryController::class, 'create']);
            Route::post('/update/{category}', [CategoryController::class, 'update']);
            Route::get('/fetch', [CategoryController::class, 'fetch']);
            Route::put('/toggle/status/{category}', [CategoryController::class, 'toggleStatus']);
        });

        Route::prefix('skill')->group(function () {
            Route::post('/create', [SkillController::class, 'create']);
            Route::put('/update/{skill}', [SkillController::class, 'update']);
            Route::get('/fetch', [SkillController::class, 'fetch']);
        });

        Route::prefix('roles')->group(function () {
            Route::get('/index', [RoleController::class, 'index']);
            Route::post('/store', [RoleController::class, 'store']);
            Route::put('/update/{id}', [RoleController::class, 'update']);
            Route::delete('/delete/{id}', [RoleController::class, 'delete']);
        });
    });
});
