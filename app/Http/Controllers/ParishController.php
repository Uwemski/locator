<?php

namespace App\Http\Controllers;
use App\Events\ParishRegistered;
use App\Models\Parish;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterParishRequest;
use App\Http\Requests\ParishUpdateLocationRequest;
use App\Http\Requests\ParishLoginRequest;
use App\Http\Requests\ParishUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;



class ParishController extends Controller
{
    //a function to logout 
    public function logout(){
        Auth::guard('parish')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/parish-login');
    }


    // a function to handle login
     public function login(ParishLoginRequest $request){
        $data = $request->validated();
        
        if(Auth::guard('parish')->attempt(['email'=> $data["email"], "password"=> $data["password"]])){
            return redirect('parish-dashboard');
        }else{
            return redirect()->back()->with("loginError", "There was an error upon login, please try again");
        }
     }


    //a function to handle registration
    public function register(RegisterParishRequest $request){
        //created a form request to make my controller cleaner
        $data = $request->validated();

        //try-catch
        try{
            //create a record
            if($request->hasFile('photo')){
                $path= $request->file('photo')->store('uploads', 'public');
            
                $data['image'] = $path;
            }
            $m = Parish::create($data);
            
            //use professional services
            // event(new ParishRegistered($m));

            return redirect()->route('login')->with('success', 'Parish registered successfully. Please log in.');
        }catch(QueryException $e){
            //query exception 23000
            if($e->getCode() == "23000"){
                return redirect()->back()->with("error", "Email already exist, please use another one ");
            }
            return back()->with('error', 'Failed to register parish. Try again.');
        }
    }

    //a function for parish to update
    public function updateSelf(ParishUpdateRequest $request){
        $parish = Auth::guard('parish')->user();

        //thank Goodness for form request
        $data = $request->validated();

        //update goes here
        $parish->update($data);

        return redirect()->back()->with('success', 'Information updated successfully');
    }

    //a function to manage location 
    public function manageLocation(ParishUpdateLocationRequest $request){
        $parish = Auth::guard('parish')->user();
        
        //validate
        $data = $request->validated();

        $parish->update($data);
        //redirect
        return redirect()->back()->with('success', 'Profile updated successfully');

    }


    //public function for parish to view
    public function index(){
        //fetch
        $parish = Auth::guard('parish')->user();

        //send
        return view('parish.parish-dashboard', compact('parish'));
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
        
        if($parishes->isNotEmpty() ){
            return view('visitors-search', compact('parishes'));
        }else{
            return redirect()->back()->with("error", "Search request does not found, try again later");
        }
        
    }

    //a methood to dlete event 
    public function delete($id) {
        // dd('hujhjhjh');
        $eve = Event::findOrFail($id);

        $s = $eve->delete();
        if($s) {
            return redirect()->back()->with('success', 'event deleted successfully');
        }else {
            return redirect()->back()->with('error', 'Error! try again later');
        }
    }

    public function updateProfileIndex() {
        $id = auth('parish')->id();
        
        $parish = Parish::findOrFail($id);
        return view('parish.update-profile', compact('parish')); 
    }
}
