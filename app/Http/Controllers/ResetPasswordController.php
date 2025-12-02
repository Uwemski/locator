<?php

namespace App\Http\Controllers;

use App\models\Parish;
use App\models\Admin;
use App\models\PasswordResetToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOtp;
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
        
        //never trust the user
        $data['email'] = strip_tags($data['email']);

        //check db for user
        $parish = Parish::where('email', $data['email'])->first();
        if(!$parish){
            return response()->json(['error'=> 'Email not found'], 404);
        }

        //trycatch should be here
        $otp = rand(1000, 9999);
        $parish = PasswordResetToken::updateOrCreate(
            ['email' => $data['email'] ],
            ['token' => $otp]);
        $subject = "OTP for Password Reset";

        Mail::to($parish->email)->send(new NewOtp($otp));

        return response()->json(['message' => 'OTP sent to your email'], 404);
    }

    public function resetPassword(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        //strip
        foreach($data as $key => $val){
            $data[$key] = strip_tags($val);
        }

        $otpRecord = PasswordResetToken::where('email', $data['email'])
                                        ->where('token', $data['otp'])
                                        ->first();

        if(!$otpRecord){
            return response()->json(['Error'=> 'Record does not exist']);
        }

        $parish = Parish::where('email', $data['email']);
        //question: is it good to check a condition on the basis that the above returns false or null. Remember we checked this in the previous method that led to this

        $parish->password = hash::make($data['password']);
        $parish->save();

        //delete otprecord
        $otpRecord->delete();
    }
}
