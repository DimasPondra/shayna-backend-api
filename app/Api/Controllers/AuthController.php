<?php

namespace App\Api\Controllers;

use App\Api\Requests\LoginRequest;
use App\Api\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !Hash::check($request->password, $user->password) ||
            $user->role == User::ROLE_USER
        ) {
            return response()->json([
                'message' => 'Login credentials are invalid'
            ], 403);
        }

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token
        ]);
    }
}
