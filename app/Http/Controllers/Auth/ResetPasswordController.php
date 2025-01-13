<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function reset(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'require|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user) use ($request) {
            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->save();
        });

        return $status === Password::PASSWORD_RESET ? response()->json(['message' => 'Password reset successfully'], 200) : response()->json(['error' => 'Failed to reset password'], 400);
    }
}
