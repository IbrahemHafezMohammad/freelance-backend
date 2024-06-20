<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'message' => 'PLAYER_CREATED_SUCCESSFULLY',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }
}
