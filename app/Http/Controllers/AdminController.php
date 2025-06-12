<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Parish;
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
            return redirect()->route('adminDashboard');
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
            'confirmPasword' => 'required|min:4|max:255',
            'role'=> 'required'
        ]);

        //strip tags
        $incomingData['name'] = strip_tags($incomingData['name']);
        $incomingData['email'] = strip_tags($incomingData['email']);
        $incomingData['password'] = strip_tags($incomingData['password']);
        $incomingData['confirmPassword'] = strip_tags($incomingData['confirmPassword']);

        //check if the two passwords match
        if( $incomingData['password'] == $incomingdData['confirmPassword']){
            //hash the password
            $incomingData['password'] = bcrypt($incomingData['password']);
            // dd($incomingData); debugging checkpoint



            //create the admin
            $admin = Admin::create($incomingData);
            if($admin){
                return redirect()->route('admin_login')->with("Successfull", "Admin has been created successfully");
            }else{
                return redirect()->back()->with("Error", "Error encountered, please try again later");
            }
        }
        
    }

    public function logout(Request $request){
        Auth::logout();

        return redirect()->route('admin_login'); 
    }

    //a method to delete a user
    public function destroy($id){
        $user = User::find($id);

        $user->delete();

        return redirect()->back()->with('deleted_success', 'User deleted successfully.');
    }

    //a method to delete a parish
    public function parish_destroy($id){
        $parish = Parish::find($id);

        $parish->delete();

        return redirect()->back()->with('deleted_success', 'Parish deleted Successfully.');

    }

    //a method to update
    public function update(Request $request, $id){
        $data = $request->validate([
            'status' => 'required|in:pending,verified,rejected',
        ]);

        //dd($data);
        //find the parish
        $parish = Parish::find($id);

        //update
        $parish->status = $data['status'];
        $parish->admin_id = Auth::guard('admin')->id();

        $parish->save();

        return redirect()->back()->with("success", "Status updated successfully");
    }
}
