<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Parish;
use App\Models\Service;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
//testing
//use Illuminate\Support\Facades\Http; This is to learn API 


class AdminController extends Controller
{
    //nearest parish 
    public function getNearest(Request $request)
    {
        $userLat = $request->query('lat');
        $userLng = $request->query('lng');

        $nearest = Parish::where('status', 'verified')
            ->get()
            ->map(function ($parish) use ($userLat, $userLng) {
                $parish->distance = sqrt(pow($parish->latitude - $userLat, 2) + pow($parish->longitude - $userLng, 2));
                return $parish;
            })
            ->sortBy('distance')
            ->first();

        return response()->json([
            'name' => $nearest->name,
            'lat' => $nearest->latitude,
            'lng' => $nearest->longitude
        ]);
    }
    //a public function to count total number of parishes and users
    //I created seperate methods for both but later realised you can do something like below.note:they are being used on the same page
    public function numberOfParishesUsers(){
        $admin = Auth::guard('admin')->user();

        //if the above results
        if($admin){
            $parishes = Parish::count();
            $users = User::count();

            $verifiedParishes = Parish::where('status', 'verified')->count();

            return view('admin.admin_dashboard', compact('parishes', 'users', 'verifiedParishes') );
        }
        //$parishes = Parish::where('status', 'pending')->count();        
    }

    //a public function to show verified parishes 
    public function showVerifiedParishes(){
        //dd('controller is working!');
        $verifiedParish = Parish::with('services')->where('status', 'verified')->get();

        return view('map', compact('verifiedParish'));
    }

    //public function to vew parishes
    public function viewAllParishes(){
        $parishes = Parish::cursorPaginate(7);
        return view('admin.all_parish', compact('parishes'));
    }

    //public function to view users
    public function viewAllUsers(){
        //fetch all from DB
        $users = User::simplePaginate(10);
        return view('admin.all_users', compact('users'));
    }


    // Admin login function
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|min:3|email',
            'password' => 'required|min:3',
        ]);

        //strip tags for bad input
        $data['email'] = strip_tags($data['email']);
        $data['password'] = strip_tags($data['password']);

        //dd($data);
        
        
        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'] ])) {
            //auth()->login($data);
            return redirect()->route('adminDashboard');
        } else {
             return redirect()->back()->with("Error", "Invalid details, please confirm and try again.");
        }
    }

    //function for admin to register
    public function register(Request $request){
        //validate
        $incomingData = $request->validate([
            'name'=> 'required|min:3',
            'email'=> 'required|min:3|email|unique:admin,email',
            'password'=> 'required|min:4|max:255',
            'confirmPassword' => 'required|min:4|max:255',
            'role'=> 'required'
        ]);

        //still stripping, just in a shorter way
        foreach($incomingData as $key => $value){
            $incomingData[$key] = strip_tags($value);
        }

         // check if the two passwords match
        if ($incomingData['password'] !== $incomingData['confirmPassword']) {
            return redirect()->back()->with("Error", "Error encountered, passwords do not match");
        }

        // hash password & unset confirmPassword
        $incomingData['password'] = bcrypt($incomingData['password']);
        unset($incomingData['confirmPassword']);

        try {
            $admin = Admin::create($incomingData);
            return redirect()->route('admin_login')->with("Successfull", "Admin has been created successfully");
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->back()->with("Error", "Email already in use, please register with another email");
            }
            return redirect()->back()->with("Error", "An unexpected error occurred, please try again later");
        }
    }

    //method to log out
    public function logout(Request $request){
        Auth::guard('admin')->logout();

        return redirect()->route('admin_login'); 
    }

    //a method to delete a user
    public function destroy($id){
        $user = User::find($id);

        $user->delete();

        return redirect()->back()->with('deleted_success', 'User deleted successfully.');
    }

    //what if the deleting fails, How do your users know?
    //a method to delete a parish
    public function parish_destroy($id){
        $parish = Parish::find($id);

        $parish->delete();

        return redirect()->back()->with('deleted_success', 'Parish deleted Successfully.');

    }

    //a method to update
    public function update(Request $request, $id){
        $data = $request->validate([
            'status' => 'required|in:pending,verified,suspended',
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

    //a method to show activeUsers
    public function showActiveParishes(){
        //get verified parish
        $activeParish = Parish::where('status', 'verified')->simplePaginate(5);  
    
        return view('admin.active_parish', compact('activeParish'));
    }

    //a method to show unverified and pending parishes
    public function showUnverifiedParishes(){
        //conn
        $unverified = Parish::whereIn('status', ['pending', 'suspended'])->get();

        return view('admin.unverified', compact('unverified'));
    }

    //a method to show suspended parishes
    public function showSuspendedParish(){
        $admin = Auth::guard('admin')->user();

        if($admin){
            $suspended = Parish::where('status', 'suspended')->get();

            return view('admin.suspended_parish', compact('suspended'));
        }
    }

    //a method to search
    public function search(Request $request){
        //conn
        $incomingData = $request->validate([
            'name' => 'required|min:3'
        ]);

        $incomingData['name'] = strip_tags($incomingData['name']);

        $parishes = Parish::where("name", "like", "%{$incomingData['name']}%")
                        ->orWhere("city", "like", "%{$incomingData['name']}%")
                        ->orWhere("state", "like", "%{$incomingData['name']}%")
                        ->get();

        if($parishes->isNotEmpty()){
            return view('admin.search', compact('parishes'));
        }else{
            return redirect()->back()->with('error', 'Requested name does not exist, try again later!');
        }
    }
 
    public function testing(){
        $ip = request()->ip();                // something like 127.0.0.1
        $url = "http://ip-api.com/" . $ip;    // http://ip-api.com/127.0.0.1
        $data = Http::get($url);   
    }
}
