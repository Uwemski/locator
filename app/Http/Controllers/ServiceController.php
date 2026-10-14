<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\Parish;
use App\Http\Requests\StoreServicesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    //a method to create a service by parish
    public function store(StoreServicesRequest $request){
        //validate
        $data = $request->validated();

        //what if I use route model binding by injecting the parish model into the method? I can get the parish id from the model. But for now, I'll use auth to get the parish id.That way my code is cleaner. The comented code below is the route model binding approach. I can use it later if I want to.

        // $parish_id = $request->user('parish')->id;

        // //dd($data);
        // $service = $parish->services()->create([
        //     'name' => $data['name'],
        //     'time' => $data['time'],
        //     'day' => $data['day'],
        //     'parish_id' => $parish_id
        // ]);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Service created successfully',
        //     'data' => $service,
        // ], 201);
        $data['parish_id'] = Auth::guard('parish')->id();

        if(!empty($data['parish_id']) ){
            $service = Service::create($data);
            if($service){
                return response()->json([
                    'success' => true,
                    'message' => 'Service created successfully',
                    'data' => $service,
                ], 201);
            }else{
                return response()->json([
                    'success' => false,
                    'error' => 'Something went wrong',
                ], 422);
            }
        }else{
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized!, Login to enable access'
            ], 401);
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
    public function destroy(Service $service){
        //route model binding. Consice and clean code. No need to find the service by id. Laravel will automatically inject the service model instance based on the id in the route.

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
