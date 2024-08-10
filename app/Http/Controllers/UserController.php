<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class UserController extends Controller
{
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        try {
            // Decrypt the token
            $decrypted = Crypt::decrypt($request->token);
            Log::info('Decrypted verification token: ' . $decrypted);

            // Split the decrypted string into email and timestamp
            [$email, $timestamp] = explode('|', $decrypted);

            // Check if the token has expired (more than 1 hour old)
            if (Carbon::createFromTimestamp($timestamp)->addSecond()->isPast()) {
                return response()->json(['message' => 'VERIFICATION_TOKEN_EXPIRED'], 400);
            }

            $user = $request->user();

            if ($user->email !== $email) {
                return response()->json(['message' => 'INVALID_VERIFICATION_TOKEN'], 400);
            }

            if ($user->hasVerifiedEmail()) {
                return response()->json(['message' => 'EMAIL_ALREADY_VERIFIED'], 400);
            }

            $user->markEmailAsVerified();

            return response()->json(['message' => 'EMAIL_VERIFIED']);
        } catch (\Exception $e) {
            // Handle the case where the token is invalid or decryption fails
            Log::error('Verification token decryption failed: ' . $e->getMessage());
            return response()->json(['message' => 'INVALID_VERIFICATION_TOKEN'], 400);
        }
    }
}
