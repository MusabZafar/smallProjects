<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     * This creates a new user and immediately issues a Sanctum token 
     * so they are logged in right after signing up.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Always hash passwords!
        ]);

        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'user' => $user,
        ], 201);
    }

    /**
     * Handle user login.
     * We check the credentials against the database. If they match, 
     * we generate a new plainTextToken for the user to use in Postman.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = $request->user();

            return response()->json([
                'token' => $user->createToken('api')->plainTextToken,
                'user' => $user,
            ]);
        }

        // Return 401 if login fails
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    /**
     * Handle user logout.
     * This deletes the specific token being used for the current request, 
     * effectively logging the user out.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
