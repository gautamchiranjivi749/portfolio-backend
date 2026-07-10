<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials.'
        ], 401);
    }

    $user = Auth::user();

    // Allow only admin users
    if ($user->role !== 'admin') {
        Auth::logout();

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized.'
        ], 403);
    }

    // Remove old tokens (optional)
    $user->tokens()->delete();

    $token = $user->createToken('admin-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login successful.',
        'token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
}

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.'
        ]);
    }
}
