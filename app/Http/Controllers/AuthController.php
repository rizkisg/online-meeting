<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import User model
use Illuminate\Support\Facades\Hash; // Import untuk hashing password
use Illuminate\Support\Facades\Auth; // Import untuk autentikasi

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6',
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Buat user baru
        $user = User::create($validated);

        // Kembalikan respons sukses
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * Login a user and issue a token.
     */
    public function login(Request $request)
    {
         
         $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        // Ambil kredensial dari request
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = Auth::guard('api')->attempt($credentials)) {
                \Log::error('Invalid credentials', ['credentials' => $credentials]);
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        
        

        return response()->json([
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 // TTL default dalam detik
        ]);
    }
}
