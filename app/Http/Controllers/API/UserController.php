<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Login user
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user){
                return response([
                    'message' => 'Login credentials are invalid.'
                ], 401);
            }
            $token = $user->createToken('access_token')->plainTextToken;
            return response([
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
                'message' => 'User logged in successfully.',
            ]);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
