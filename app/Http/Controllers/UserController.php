<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //a function to login

    public function login(Request $request){
        $data = $request->validate([
            "email"=> "required|min3",
            "password"=> "required|min:4"
        ]);

        //strip tags
        $data["email"] = strip_tags($data["email"]);
        $data["password"] = strip_tags($data["password"]);

        if(auth()->attempt(['email'=> $data["email"], "password"=> $data["password"]])){
            return redirect('dashboard');
        }else{
            return redirect()->back()->with("loginError", "There was an error upon login, please try again");
        }
    }
    
    
    //a ffunction to register
    public function register(Request $request){
        //validate
        $incomingData= $request->validate([
            "name"=> "required|min:5",
            "email"=> "required|min:4",
            "phone"=> "required",
            "password"=> "required|min:4|max:18",
            "confirmPassword"=> "required|min:4|max:18"
        ]);

        //strip tags: Never trust your users
        $incomingData["name"]= strip_tags($incomingData['name']);
        $incomingData["email"]= strip_tags($incomingData["email"]);
        $incomingData["phone"]= strip_tags($incomingData["phone"]);
        $incomingData["password"]= strip_tags($incomingData["password"]);
        $incomingData["confirmPassword"]= strip_tags($incomingData["confirmPassword"]);

        //check if passwords match
        if ($incomingData["password"] == $incomingData["confirmPassword"]){
            $incomingData["password"]= bcrypt($incomingData["password"]);

            //create a new user
            $user = User::create($incomingData);
            if($user){
                return redirect()->route('/userLogin')->with("success", "Account has been created successfully");
            }else{
                return redirect()->back()->with("error", "Error was encountered, please try again");
            }
        }else{
            return redirect()->back()->with("Password error", "Passwords do not match");
        }

    }
}
