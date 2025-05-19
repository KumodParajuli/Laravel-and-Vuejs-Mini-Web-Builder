<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        try {

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'User register successfully!'
            ], 201);
        } catch (\Exception $ex) {

            return response()->json([
                'error' => 'Unable to save the user record, please refresh webpage and try again. If still problem persists contact with administrator'
            ]);
        }
    }

    public function login(LoginRequest $request)
    {

        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {

            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], 200);
    }

    public function checkUserStatus()
    {

        $status = auth()->check() ? true : false;
        return response()->json([
            'authenticated' => $status
        ], 200);
    }

    public function logout(Request $request)
    {

        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'User logged out'
        ], 201);
    }
}
