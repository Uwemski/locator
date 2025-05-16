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
}
