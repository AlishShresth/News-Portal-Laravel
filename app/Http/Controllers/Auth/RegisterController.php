<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $profileImagePath = null;
        if ($request->hasFile('profile_picture')) {
            $profileImagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'profile_picture' => $profileImagePath,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $user = User::find($user->id);

        return response()->json([
            'message' => 'Registration successful',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'data' => $user,
            'profile_picture_url' => $profileImagePath ? asset('storage/' . $profileImagePath) : null
        ], 201);
    }
}
