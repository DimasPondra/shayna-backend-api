<?php

namespace App\Api\Controllers\Client;

use App\Api\Requests\LoginRequest;
use App\Api\Requests\RegisterRequest;
use App\Api\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !Hash::check($request->password, $user->password) ||
            $user->role == User::ROLE_ADMIN
        ) {
            return response()->json([
                'message' => 'Login credentials are invalid'
            ], 403);
        }

        $token = $user->createToken('authToken', ['client'])->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'User successfully logged out.'
        ]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->merge([
                'password' => bcrypt($request->password)
            ]);

            $data = $request->only([
                'name', 'email', 'password',
                'phone_number', 'address'
            ]);

            $user = new User();
            $this->userRepository->store($user->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Register account successfully.'
        ], 201);
    }
}
