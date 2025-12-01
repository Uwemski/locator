<?php

namespace App\Http\Controllers;

use App\models\User;
use Illuminate\Suport\Facades\Mail;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    //
    public function index() {
        return view('auth.forget-password');
    }

    public function forgetPassword(Request $request) {
        //validate
        $data = $request->validate([
            'email' => 'required|email|min:3'
        ]);

        $user = User::where('email', $dat['email'])->first();
        if(!$user){
            return response()->json(['error'=> 'Email not found'], 404);
        }

        $otp = rand(1000, 9999);
        $user->update(['token' => $otp]);
        $subject = "OTP for Password Reset";

        Mail::to($user->email)->send(new OTPMail($otp));

        return response()->json(['message' => 'OTP sent to your email'], 404);
    }
}
