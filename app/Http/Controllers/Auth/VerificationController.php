<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
   public function verify(Request $request){
    if($request->user()->hasVerifiedEmail()){
        return response()->json(['message' => 'Email already verified'], 200);
    }

    $request->user()->markEmailAsVerified();

    return response()->json(['message' => 'Email verified successfully'], 200);
   }

   public function resend(Request $request){
    if($request->user()->hasVerifiedEmail()){
        return response()->json(['message' => 'Email already verified'], 200);
    }
    $request->user()->sendEmailVerificationNotification();

    return response()->json(['message' => 'Verification email sent'],200);
   }
}
