<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\LoginEmployerRequest;

class EmployerController extends Controller
{
    public function login(LoginEmployerRequest $request)
    {
        $validated = $request->validated();

        if (!$user = User::checkEmployerUserName($validated['user_name'])) {
            return response()->json([
                'status' => false,
                'message' => 'USER_DOES_NOT_EXIST'
            ], 404);
        }

        $permissionArray = $user->getAllPermissions()->pluck('name');
        
        $clientIP = $request->ip();

        if (!$user->verifyPassword($validated['password'])) {
            return response()->json([
                'status' => false,
                'message' => 'PASSWORD_INCORRECT'
            ], 403);
        }

        if (!$user->employer->status) {
            return response()->json([
                'status' => false,
                'message' => 'ACCOUNT_INACTIVE'
            ], 402);
        }

        if ($user->employer->is_2fa_enabled) {

            if (!$request->otp) {

                return response()->json([
                    'status' => false,
                    'message' => 'OTP_REQUIRED',
                ], 422);
            }

            if (!$user->employer->verifyOTP($validated['otp'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP_INCORRECT'
                ], 403);
            }
        }

        $user->tokens()->delete();

        $user->loginHistory()->create(['ip' => $clientIP]);

        $user->load('roles:name');

        return response()->json([
            'status' => true,
            'message' => 'EMPLOYER_LOGGED_IN_SUCCESSFULLY',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user_name' => $user->user_name,
            'user_id' => $user->id,
            'employer'  => $user->employer->id,
            'is_2fa_enabled' => $user->employer->is_2fa_enabled,
            'roles' => $user->roles->map(fn($item) => Arr::except($item, 'pivot')),
            'permissions' => $permissionArray,
        ], 200);
    }
}
