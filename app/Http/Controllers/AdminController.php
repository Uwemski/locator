<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Admin login function
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|min:3|email',
            'password' => 'required|min:3',
        ]);

        $data['email'] = strip_tags($data['email']);
        $data['password'] = strip_tags($data['password']);

        //dd($data);
        
        // Attempt to authenticate using the Admin model
        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'] ])) {
            //auth()->login($data);
            return redirect()->route('dashboard');
        } else {
             return redirect()->back()->with("Error", "Invalid details, please confirm and try again.");
        }
    }

    //fucntion for admin to register
    public function register(Request $request){
        //validate
        $incomingData = $request->validate([
            'name'=> 'required|min:3',
            'email'=> 'required|min:3',
            'password'=> 'required|min:4|max:255',
            'role'=> 'required'
        ]);

        //strip tags
        $incomingData['name'] = strip_tags($incomingData['name']);
        $incomingData['email'] = strip_tags($incomingData['email']);
        $incomingData['password'] = strip_tags($incomingData['password']);


        //hash the password
        $incomingData['password'] = bcrypt($incomingData['password']);
        // dd($incomingData); debugging checkpoint



        // //create the admin
        $admin = Admin::create($incomingData);
        if($admin){
            return redirect()->route('admin_login')->with("Successfull", "Admin has been created successfully");
        }else{
            return redirect()->back()->with("Error", "Error encountered, please try again later");
        }
    }
}
