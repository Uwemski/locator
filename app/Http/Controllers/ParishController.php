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

        foreach($data as $key => $value){
            $data[$key] = strip_tags($value);
        }
        // dd($data); form data shows here
        
        //this woudve been the way if II wasn't using a guard
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

        //save your self stress by doing this
        foreach($data as $key => $value){
            $data[$key] = strip_tags($value);
        }

        //creat a record
        $m = Parish::create($data);
        // dd($data);


        if ($m) {
            return redirect()->route('login');
        } else {
            return back()->with('error', 'Failed to register parish. Try again.');
        }
        // dd($data);
    }

    //a function for parish to update
    public function update_self(Request $request){
        
        $parish = Auth::guard('parish')->user();

        $data = $request->validate([
            "address" => 'required|min:5',
            "pastor_name" => "required|min:5",
            "contact_no" => "required|min:10",
            "website" => "required|min:4",
            "latitude" => "required|min:3",
            "longitude" => "required|min:3",
        ]);

        //debug checkpoint
        //dd($data);

        //strip data 
        // $data['address'] = strip_tags($data['address']);
        // $data['pastor_name'] = strip_tags($data['pastor_name']);
        // $data['contact_no'] = strip_tags($data['contact_no']);
        // $data['website'] = strip_tags($data['website']);
        // $data['latitude'] = strip_tags($data['latitude']);
        // $data['longitude'] = strip_tags($data['longitude']);

        //shorter way to achieve the above 
        foreach($data as $key => $value){
            $data[$key] = strip_tags($value);
        }
        
        //update goes here
        $parish->update($data);
        //dd($parish);

        return redirect()->back()->with('success', 'Information updated successfully');

    }

    //a function to manage location 
    public function manage_location(Request $request){
        $parish = Auth::guard('parish')->user();
        
        //validate
        $data = $request->validate([
            'latitude' => 'required|min:3',
            'longitude' => 'required|min:3'
        ]);
        //strip tags
        foreach($data as $d => $k){
            $data[$d] = strip_tags($data[$k]);
        }
        //update 
        $parish->update($data);
        //redirect
        return redirect()->back()->with('success', 'Information updated successfully');
    }


    //public function for parish to view
    public function index(){
        //fetch
        $parish = Auth::guard('parish')->user();

        //send
        return view('parish.parish_dashboard', compact('parish'));
    }

    //a method to search for a parish
    public function searchForVisitors(Request $request){
        $data = $request->validate([
            'name'=> 'required|min:3|max:25'
        ]);

        $data['name'] = strip_tags($data['name']);
        // $parishes = Parish::where("status", "verified")
        //              ->orWhere("name", "like", "%{$data['name']}%")
        //              ->orWhere("city", "like", "%{$data['name']}%")
        //              ->orWhere("state", "like", "%{$data['name']}%");

        $parishes = Parish::where("status", "verified")
                        ->where(function($query) use ($data){
                            $query->where("name", "like", "%{$data['name']}%")
                            ->orWhere("city", "like", "%{$data['name']}%")
                            ->orWhere("state", "like", "%{$data['name']}%");
                        })->get();
        
        if($parishes){
            return view('visitors_search', compact('parishes'));
        }else{
            return redirect()->back()->with("error", "Search request does not found, try again later");
        }
        
    }
}
