<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginSeekerRequest;
use App\Http\Requests\RegisterSeekerRequest;
use App\Services\WebService\WebRequestService;

class SeekerController extends Controller
{
    public function register(RegisterSeekerRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($request->getUserData($validated));
        $seekerData = $request->getSeekerData($validated);
        $seeker = $user->seeker()->create($seekerData);
        $webRequestService = new WebRequestService($request);
        $user->loginHistory()->create(['ip' => $webRequestService->getIpAddress()]);

        return response()->json([
            'user_id' => $user->id,
            'status' => true,
            'message' => 'SEEKER_CREATED_SUCCESSFULLY',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }

    public function login(LoginSeekerRequest $request)
    {
        $validated = $request->validated();

        if (!$user = User::checkSeekerUserName($validated['user_name'])) {
            return response()->json([
                'status' => false,
                'message' => 'USER_DOES_NOT_EXIST'
            ], 404);
        }

        if (!$user->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'ACCOUNT_INACTIVE'
            ], 402);
        }

        $attempts = $this->incrementLoginAttempts($user->id);

        // Check if login attempts exceeded
        if ($attempts > 10) {
            return response()->json([
                'status' => false,
                'message' => 'LOGIN_ATTEMPTS_EXCEEDED'
            ], 403);
        }

        if (!$user->verifyPassword($validated['password'])) {

            return response()->json([
                'status' => false,
                'message' => 'PASSWORD_INCORRECT'
            ], 403);
        }

        $this->resetLoginAttempts($user->id);

        $user->tokens()->delete();

        $webrequestservice = new WebRequestService($request);

        $request_ip = $webrequestservice->getIpAddress();

        $user->loginHistory()->create(['ip' => $request_ip]);

        $user_details = [
            "user_id" => $user->id,
            "user_name" => $user->user_name,
            'payer_id' => $user->seeker->id,
        ];

        return response()->json([
            'status' => true,
            'message' => 'USER_LOGGED_IN_SUCCESSFULLY',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'data' => $user_details
        ], 200);
    }

    private function incrementLoginAttempts($userId)
    {
        $cacheKey = 'login_attempts_' . $userId;
        $loginAttempts = cache($cacheKey, 0) + 1;

        cache([$cacheKey => $loginAttempts], now()->addHours(1)); // Increase attempts and set expiration time

        return $loginAttempts;
    }

    private function resetLoginAttempts($userId)
    {
        $cacheKey = 'login_attempts_' . $userId;
        cache()->forget($cacheKey); // Delete the cache
    }
}
