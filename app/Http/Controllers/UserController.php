<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //a function to logout
    public function logout(Request $request){
        Auth::logout();

        return redirect('/home');
    }


    //a function to login
    public function login(Request $request){
        $data = $request->validate([
            "email"=> "required|min:3",
            "password"=> "required|min:4"
        ]);

        //strip tags
        $data["email"] = strip_tags($data["email"]);
        $data["password"] = strip_tags($data["password"]);

        if(auth()->attempt(['email'=> $data["email"], "password"=> $data["password"]])){
            return redirect('userDashboard');
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

        //short way for the above
        // foreach($incomingData as $key => $value){
        //     $data[$key] = strip_tags($value);
        // }
        //debug checkpoint: no bugs found
        //dd($incomingData);

        //check if passwords match
        if ($incomingData["password"] === $incomingData["confirmPassword"]){
            //if they do hash the pass
            $incomingData["password"]= bcrypt($incomingData["password"]);

            //create a new user
            $user = User::create($incomingData);
            //if created succesfully, then direct them to login page and if not redirect back with error
            if($user){
                return redirect()->route('userLogin')->with("success", "Account has been created successfully");
            }else{
                return redirect()->back()->with("error", "Error was encountered, please try again");
            }
        }else{
            return redirect()->back()->with("Password error", "Passwords do not match");
        }
    }
}
