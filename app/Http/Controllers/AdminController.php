<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\RegisterAdminRequest;
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
    public function getNearest(Request $request)
        {
            $userLat = (float) $request->query('lat');
            $userLng = (float) $request->query('lng');

            $nearest = Parish::where('status', 'verified')
                ->selectRaw("
                    *,
                    (6371 * 2 * ASIN(SQRT(
                        POW(SIN(RADIANS(latitude  - ?) / 2), 2) +
                        COS(RADIANS(?)) *
                        COS(RADIANS(latitude)) *
                        POW(SIN(RADIANS(longitude - ?) / 2), 2)
                    ))) AS distance_km
                ", [$userLat, $userLat, $userLng])
                ->orderBy('distance_km')
                ->first();

            return response()->json([
                'name'        => $nearest->name,
                'lat'         => $nearest->latitude,
                'lng'         => $nearest->longitude,
                'distance_km' => round($nearest->distance_km, 2)
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

            return view('admin.admin-dashboard', compact('parishes', 'users', 'verifiedParishes') );
        }
        //$parishes = Parish::where('status', 'pending')->count();        
    }

    //a public function to show verified parishes on map
    public function showVerifiedParishes(){
        $verifiedParish = Parish::with('services')->where('status', 'verified')->simplePaginate(7);

        return view('map', compact('verifiedParish'));
    }

    //public function to vew parishes
    public function viewAllParishes(){
        $parishes = Parish::simplePaginate(7);
        return view('admin.parishes.index', compact('parishes'));
    }

    //public function to view users
    public function viewAllUsers(){
        //fetch all from DB
        $users = User::simplePaginate(10);
        return view('admin.users.index', compact('users'));
    }


    // Admin login function
    public function login(AdminLoginRequest $request)
    {
        $data = $request->validated();
        
        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'] ])) {
            //auth()->login($data);
            return redirect()->route('adminDashboard');
        } else {
             return redirect()->back()->with("Error", "Invalid details, please confirm and try again.");
        }
    }

    //function for admin to register
    public function register(RegisterAdminRequest $request){
        //validate
        $incomingData = $request->validated();

        // hash password & unset confirmPassword
        $incomingData['password'] = bcrypt($incomingData['password']);

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
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('admin-login'); 
    }

    //a method to delete a user
    public function destroy($id){
        $user = User::find($id);

        $user->deleteQuietly();

        return redirect()->back()->with('deleted_success', 'User deleted successfully.');
    }

    //what if the deleting fails, How do your users know?
    //a method to delete a parish
    public function parishDestroy($id){
        $parish = Parish::find($id);

        $parish->deleteQuietly();

        return redirect()->back()->with('deleted_success', 'Parish deleted Successfully.');

    }

    //a method to update
    public function update(Request $request, Parish $parish){    
        $data = $request->validate([
            'status' => 'required|in:pending,verified,suspended',
        ]);


        $data['admin_id']= Auth::guard('admin')->id();
        // dd($parish);hits here
        // //update
        $parish->update($data);

        // return redirect()->back()->with('success', 'status updated successfully');
        $parish->refresh();
        return response()->json([
            'success' => true,
            'message' => 'Parish updated successfully',
            'name' => $parish->name,
            'status' => $parish->status
        ]);
    }

    //a method to show activeUsers
    public function showActiveParishes(){
        //get verified parish
        $parishes = Parish::where('status', 'verified')->simplePaginate(5);  
    
        return view('admin.parishes.verified', compact('parishes'));
    }

    //a method to show unverified and pending parishes
    public function showUnverifiedParishes(){
        //conn
        $parishes = Parish::where('status', 'pending')->latest()->simplePaginate(10);

        return view('admin.parishes.unverified', compact('parishes'));
    }

    //a method to show suspended parishes
    public function showSuspendedParish(){
        $admin = Auth::guard('admin')->user();

        if($admin){
            $parishes = Parish::where('status', 'suspended')->latest()->simplePaginate(10);

            return view('admin.parishes.suspended-parish', compact('parishes'));
        }
    }

    //a method to search
    public function search(Request $request){
        //conn
        $incomingData = $request->validate([
            'search' => 'required|string|max:50',
            'status' => 'nullable|in:verified,suspended,pending,all'
        ]);

        $search = $incomingData['search'];
        $status = $incomingData['status'];

        //start a query
        $query = Parish::query();
        $search = strip_tags($search);

        //filter by status
        if($status == 'verified'){
            $query->where('status', 'verified');
        }else if($status == 'suspended'){
            $query->where('status', 'suspended');
        }else if($status == 'pending') {
            $query->where('status', 'pending');
        }

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where("name", "like" , "%{$search}")
                    ->orWhere("city", "like", "%{$search}%")
                    ->orWhere("state", "like", "%{$search}%")
                    ->latest()
                    ->get();
            });
        }
        // $parishes = Parish::where("name", "like", "%{$incomingData['name']}%")
        //                 ->orWhere("city", "like", "%{$incomingData['name']}%")
        //                 ->orWhere("state", "like", "%{$incomingData['name']}%")
        //                 ->latest()
        //                 ->simplePaginate(10);

        //fetch results
        $parishes = $query->simplePaginate(10);

        //return view
        if($status == 'verified') {
            return view('admin.parishes.verified', compact('parishes'));
        } else if($status == 'pending') {
            return view('admin.parishes.unverified', compact('parishes'));
        } else if($status == 'suspended') {
            return view('admin.parishes.suspended-parish', compact('parishes'));
        } else {
            return view('admin.parishes.index', compact('parishes') );
        }
        // if($parishes->isNotEmpty()){
        //     return view('admin.search', compact('parishes'));
        // }else{
        //     return redirect()->back()->with('error', 'Requested name does not exist, try again later!');
        // }
    }
 
    public function testing(){
        $ip = request()->ip();                // something like 127.0.0.1
        $url = "http://ip-api.com/" . $ip;    // http://ip-api.com/127.0.0.1
        $data = Http::get($url);   
    }
}
