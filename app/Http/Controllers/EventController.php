<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Parish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    //
    public function create(Request $request){
        //validate
        $data = $request->validate([
            'title' => 'required|min:4',
            'description' => 'required|min:5',
            'event_date' => 'required|min:3',
        ]);

        $data['parish_id'] = Auth::guard('parish')->id();

        //strip tags
        foreach($data as $key => $value){
            $data['key'] = strip_tags($value);
        }
        
        //dd($data);//data is been seen

        //create if parish_id is present   
        if(!empty($data['parish_id'])){
            $event = Event::create($data);
            if($event){
                return redirect()->back()->with('success', 'event created successfully');
            }else{
                return redirect()->back()->with('error', 'event not created successfully');
            }
        }else{ 
            return redirect()->back()->with('error', 'parish Id missing, You are a criminal!!');
        }    
    }

}
