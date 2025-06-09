<?php

namespace App\Http\Controllers;
use App\Models\Parish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ParishController extends Controller
{
    //a function to logout 
    public function logout(){
        Auth::guard('parish')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/parish_login');
    }


    // a function to handle login
     public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|min:3|',
            'password' => 'required|min:5'
        ]);

        $data['email']= strip_tags($data['email']);
        $data['password']= strip_tags($data['password']);

        // dd($data); form data shows here
        // if(auth()->attempt(['email'=> $data['email'], 'password'=> $data['password']]) ){
        //     return redirect()->route('userDashboard')->with('LoginSuccess', 'welcome to your dashbaord');
        // }else{
        //     return redirect()->back()->with('LoginError', 'Check your credentials and try again');
        // }

        if(Auth::guard('parish')->attempt(['email'=> $data["email"], "password"=> $data["password"]])){
            return redirect('parish_dashboard');
        }else{
            return redirect()->back()->with("loginError", "There was an error upon login, please try again");
        }
     }


    //a function to handle registration
    public function register(Request $request){
        $data = $request->validate([
            "name" => "required|min:4",
            "email" => "required|min:4|max:255",
            "password" => "required|min:5|max:255",
            "address"=> "required|min:4|max:255",
            "city" => "required|min:4|max:255",
            "state" => "required|min:4|max:255",
            
            "longitude" => "required",
            "latitude" => "required"
        ]);

        $data["name"]= strip_tags($data["name"]);
        $data["email"] = strip_tags($data["email"]);
        $data["address"]= strip_tags($data["address"]);
        $data["city"]= strip_tags($data["city"]);
        $data["state"] = strip_tags($data["state"]);
        //$data["country"] = strip_tags($data["country"]);

        $m = Parish::create($data);
        // dd($data);

        // if($m){
        //     return redirect()->route('/userLogin');
        // }


        if ($m) {
    return redirect()->route('parish_login');
} else {
    return back()->with('error', 'Failed to register parish. Try again.');
}

        // dd($data);
    }
}
