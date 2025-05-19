<?php

namespace App\Http\Controllers;
use App\Models\Parish;
use Illuminate\Http\Request;

class ParishController extends Controller
{
    //a function to andle registration

    public function register(Request $request){
        $data = $request->validate([
            "name" => "required|min:4",
            "email" => "required|min:4|max:255",
            "password" => "required|min:5|max:255",
            "address"=> "required|min:4|max:255",
            "city" => "required|min:4|max:255",
            "state" => "required|min:4|max:255",
            "country" => "required|min:4|max:255",
        ]);

        $data["name"]= strip_tags($data["name"]);
        $data["email"] = strip_tags($data["email"]);
        $data["address"]= strip_taga($data["address"]);
        $data["city"]= strip_tags($data["city"]);
        $data["state"] = strip_tags($data["state"]);
        $data["country"] = strip_tags($data["country"]);
    }
}
