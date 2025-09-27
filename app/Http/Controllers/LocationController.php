<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class LocationController extends Controller
{
    //
    public function getStates() {
        $url = "https://temikeezy.github.io/nigeria-geojson-data/data/full.json";
        $response = Http::get($url);
        
        if($response->successful() ) {
            $data = $response->json();

            $states = collect($data)->map(function ($item) {
                return $item['state']; // the state name in the JSON
            })->unique()->values();

            return response()->json($states);
        }

        return response()->json(["error" => "unable to fetch data"], 500);
    }

    public function getLgas($state)
    {
        $url = "https://temikeezy.github.io/nigeria-geojson-data/data/lgas.json";
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            // state key exists in the JSON
            if (isset($data[$state])) {
                return response()->json($data[$state]);
            }

            return response()->json([], 200); // state not found, return empty array
        }

        return response()->json(["error" => "unable to fetch data"], 500);
    }

}
