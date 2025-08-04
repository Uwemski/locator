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

        //authenticate 
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

    //for visitors
    public function visitor_search_event($id){
        //find by id
        $parish = Parish::with('events')->find($id);

        //if(!$parish){
        //     return redirect
        //}
        
        $event = $parish->events;
        //dd($event);
        if(!empty($event)){
            return view('user.parish_event', compact('event'));
        }else{
            return redirect()->back()->with('error', 'error');
        }
        
    }

    //for parish
    public function view_events_for_parish(){

        //find by id
        $id = Auth::guard('parish')->id();
        //send to blade
        $parish = Parish::findOrFail($id);

        if($parish){
            $events = $parish->events;
            if($events->isNotEmpty()){
                return view('parish.manage_events', compact('events'));
            }else{
                return redirect()->back()->with('empty', 'There are no events for your parish yet');
            }
        }else{
            return redirect()->back()->with('error', 'Parish does not exist');
        }
    }

    //route to edit
    public function edit($id){
        $event = Event::findOrFail($id);

        if(Auth::guard('parish')->id() !== $event->parish_id ){
            abort(404);  
        }else{
            return view('parish.update_event', compact('event'));
        }
    }

    //to update event by parish
    public function update(Request $request, $id){
        //find
        $event = Event::findOrFail($id);
        //validate
        $data = $request->validate([
            "title" => "required|min:3",
            "description" => "required|min:5",
            "event_date" => "required|min:3",
            "location" => "required|min:3",
        ]);
        //strip tags
        foreach($data as $d => $k){
            $data[$d] = strip_tags($k);
        }
        //verify
        $parish_id = Auth::guard('parish')->id();
        
        if($event){
            if($parish_id){
                //update
                $event->update($data);
                //save
                $event->save();
                return redirect()->back()->with("success", "Event record updated successfully");
            }else{
                return redirect()->back()->with("Illegal access", "You don't have authorization to perform thuis action");
            }
        }
    }
}
