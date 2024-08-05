<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\DummyJob;
use App\Models\JobPost;
use App\Models\Employer;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\LoginEmployerRequest;
use App\Http\Requests\UpdateEmployerRequest;
use App\Http\Requests\ViewEmployerDashboard;
use App\Http\Requests\RegisterEmployerRequest;
use App\Services\WebService\WebRequestService;

class EmployerController extends Controller
{
    public function register(RegisterEmployerRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $user = User::create($request->getUserData($validated));
            $employerData = $request->getEmployerData($validated);
            $employer = $user->employer()->create($employerData);
            $webRequestService = new WebRequestService($request);
            $user->loginHistory()->create(['ip' => $webRequestService->getIpAddress()]);
            
            event(new Registered($user));

            DB::commit();
            return response()->json([
                'user_id' => $user->id,
                'phone' => $user->phone,
                'name' => $user->name,
                'birthday' => $user->birthday,
                'email' => $user->email,
                'gender' => $user->gender,
                'gender_name' => $user->gender_name,
                'status' => true,
                'email_verified_at' => $user->email_verified_at,
                'message' => 'EMPLOYER_CREATED_SUCCESSFULLY',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'UNEXPECTED_RESPONSE',
            ], 401);
        }
    }

    public function update(UpdateEmployerRequest $request, User $user)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            if ($validated['email'] !== $user->email) {
                $user->update(['email' => $validated['email'], 'email_verified_at' => null]);
                // $user->sendEmailVerificationNotification();
                event(new Registered($user));
            }
            if ($user->update($request->getUserData($validated))) {

                DB::commit();
                return response()->json([
                    'user_id' => $user->id,
                    'phone' => $user->phone,
                    'name' => $user->name,
                    'birthday' => $user->birthday,
                    'email' => $user->email,
                    'gender' => $user->gender,
                    'gender_name' => $user->gender_name,
                    'status' => true,
                    'email_verified_at' => $user->email_verified_at,
                    'message' => 'EMPLOYER_UPDATED_SUCCESSFULLY',
                ], 200);
            }

            DB::commit();
            return response()->json([
                'status' => false,
                'message' => 'EMPLOYER_UPDATE_FAILED',
            ], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'UNEXPECTED_RESPONSE',
            ], 401);
        }
    }

    public function login(LoginEmployerRequest $request)
    {
        $validated = $request->validated();

        if (!$user = User::checkEmployerUserName($validated['user_name'])) {
            return response()->json([
                'status' => false,
                'message' => 'USER_DOES_NOT_EXIST'
            ], 404);
        }

        if (!$user->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'ACCOUNT_INACTIVE'
            ], 403);
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
            'payer_id' => $user->employer->id,
        ];

        return response()->json([
            'user_id' => $user->id,
            'phone' => $user->phone,
            'name' => $user->name,
            'birthday' => $user->birthday,
            'email' => $user->email,
            'gender' => $user->gender,
            'gender_name' => $user->gender_name,
            'status' => true,
            'email_verified_at' => $user->email_verified_at,
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

    public function dashboard(ViewEmployerDashboard $request)
    {
        $user = auth()->user()->load(['employer:id,user_id']);
        $posts = JobPost::getPosts($request->validated(), $user)->paginate(10);

        return response()->json([
            'status' => true,
            'user_data' => $user,
            'posts' => $posts,
        ]);
    }
}
