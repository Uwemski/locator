<?php

namespace App\Http\Controllers;
use App\Events\ParishRegistered;
use App\Models\Parish;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\StoreParishRequest;
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
            return redirect()->route('parish.dashboard');
        }else{
            return redirect()->back()->with("loginError", "There was an error upon login, please try again");
        }
     }


    //a function to handle registration
    public function store(StoreParishRequest $request){
        //created a form request to make my controller cleaner
        $data = $request->validated();

        //try-catch
        try{
            //create a record
            if($request->hasFile('photo')){
                //use cloudinary
                $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
                $result = $cloudinary->uploadApi()->upload(
                    $request->file('photo')->getRealPath,
                    ['folder' => 'parish']
                );

                $data['photo'] = $result['secure_url'];
            }
            $m = Parish::create($data);

            return redirect()->route('parish.login')->with('success', 'Parish registered successfully. Please log in.');
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

        $data = $request->validated();

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
        $parish = Auth::guard('parish')->user();

        return view('parish.parish-dashboard', compact('parish'));
    }

    //a method to search for a parish
    public function searchForVisitors(Request $request){
        $data = $request->validate([
            'name'=> 'required|min:3|max:25'
        ]);

        $data['name'] = strip_tags($data['name']);

        $parishes = Parish::where("status", "verified")
                        ->where(function($query) use ($data){
                            $query->where("name", "like", "%{$data['name']}%")
                            ->orWhere("address", "like", "%{$data['name']}%")
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
