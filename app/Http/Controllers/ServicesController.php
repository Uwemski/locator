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
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
        ]);

        //strip-tags
        $data['name'] = strip_tags($data['name']);
        //still stripping
        foreach($data as $key => $value){
            $data[$key] = strip_tags($value);
        }

        $data['parish_id'] = Auth::guard('parish')->id();

        if(!empty($data['parish_id']) ){//hope this works, if it doesn't we still move
            $service = Service::create($data);
            if($service){
                return redirect()->back()->with('success', 'Service created successfully');
            }else{
                return redirect()->back()->with('error', 'Unable to create, Please try again!');
            }
        }

    }
}
