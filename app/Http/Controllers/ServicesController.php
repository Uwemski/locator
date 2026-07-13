<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\Parish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    //a method to create a service by parish
    public function create(Request $request){
        //validate
        $data = $request->validate([
            'name' => 'required|min:2',
            'time' => 'required|min:3',
            'day' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
        ]);

        // //strip-tags
        // $data['name'] = strip_tags($data['name']);
        // //still stripping
        foreach($data as $key => $value){
            $data[$key] = strip_tags($value);
        }

        $data['parish_id'] = Auth::guard('parish')->id();

        //dd($data);
        if(!empty($data['parish_id']) ){//hope this works, if it doesn't we still move
            $service = Service::create($data);
            if($service){
                //return redirect()->back()->with('success', 'Service created successfully');
                return response()->json([
                    'success' => true,
                    'message' => 'Service created successfully',
                    'data' => $service,
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'error' => 'Something went wrong',
                ]);
                //return redirect()->back()->with('error', 'Unable to create, Please try again!');
            }
        }else{
            return redirect()->back()->with('error', 'Unauthorized!,Login to enable access');
        }
    }

    public function show(){
        //this function should aloow parish to view their seervices
        //is the [parish autenticated]?
        $parish_id = Auth::guard('parish')->id();

        //join bothh tables
        $parish = Parish::with('services')->find($parish_id);

        $services = $parish->services;

        //dd($services);
        return view('parish.manage-service', compact('services'));
    }

    //a function to delete service
    public function delete($id){
        //get the record
        $service = Service::find($id);

        //delete
        $yes = $service->delete();

        if($yes){
            return redirect()->back()->with('success', 'service has been deleted successfully');
        }
       
    }

    //a function to get service by id
    public function findServiceByParish($id){
        //find by id
        $parish = Parish::with('services')->find($id);

        $service = $parish->services;

        if(!empty($service)){
            return view('admin.parishes.parish-service', compact('service', 'parish'));
        }else{
            return redirect()->back()->with('error', 'parish does not have service stored');
        }
    }    
}
