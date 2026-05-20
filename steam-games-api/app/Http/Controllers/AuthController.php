<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * AuthController handles user authentication including login, registration, and logout.
 */
class AuthController extends Controller
{
    /**
     * Handle user login.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 1. Validate incoming request data
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt to authenticate the user using Laravel's Auth facade
        // Auth::attempt checks if the credentials match a user in the database
        if (!Auth::attempt($request->only('email', 'password'))) {
            // Return 401 Unauthorized if credentials are wrong
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // 3. Retrieve the authenticated user
        $user = $request->user();

        // 4. Create a new Sanctum API token for this user
        // plainTextToken returns the token string that the user must store (usually in localStorage)
        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'user' => $user,
        ]);
    }

    /**
     * Handle user registration.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // 1. Validate the registration data
        // unique:users ensures no two users have the same email
        // confirmed ensures 'password' matches 'password_confirmation'
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Create the user record in the database
        // Hash::make securely encrypts the password before saving
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // 3. Return a success response (201 Created) with a new API token
        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'user' => $user,
        ], 201);
    }

    /**
     * Handle user logout.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Delete the current access token being used for this request
        // This effectively logs the user out from this session
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}