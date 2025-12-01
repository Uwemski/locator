<?php

namespace App\Http\Controllers;

use App\models\Parish;
use App\models\Admin;
use App\models\PasswordResetToken;
use Illuminate\Suport\Facades\Mail;
use Illuminate\Support\Facades\Auth;
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

        //check db for user
        $parish = Parish::where('email', $data['email'])->first();
        if(!$parish){
            return response()->json(['error'=> 'Email not found'], 404);
        }

        $otp = rand(1000, 9999);
        $parish = PasswordResetToken::updateOrCreate(
            ['email' => $data['email'] ],
            ['token' => $otp]);
        $subject = "OTP for Password Reset";

        Mail::to($parish->email)->send(new OTPMail($otp));

        return response()->json(['message' => 'OTP sent to your email'], 404);
    }
}
