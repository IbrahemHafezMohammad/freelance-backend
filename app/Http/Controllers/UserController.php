<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Constants\UserConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = $request->user();

        $token = $user->getEmailForVerification();
        Log::info('getEmailForVerification: ' . $token);
        $hashed = sha1($token);
        if ($hashed === $request->token) {
            if ($user->hasVerifiedEmail()) {
                return response()->json(['message' => 'EMAIL_ALREADY_VERIFIED'], 400);
            }

            $user->markEmailAsVerified();

            return response()->json(['message' => 'EMAIL_VERIFIED']);
        }

        return response()->json(['message' => 'INVALID_VERIFICATION_TOKEN'], 400);
    }
}
