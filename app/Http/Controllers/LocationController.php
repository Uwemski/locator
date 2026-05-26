<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    private function fetchData(): array
    {
        return Cache::remember('ng_location_data', 86400, function () {
            $response = Http::get("https://temikeezy.github.io/nigeria-geojson-data/data/full.json");
            return $response->successful() ? $response->json() : [];
        });
    }

    public function getStates()
    {
        $data = $this->fetchData();

        $states = collect($data)
            ->pluck('state')       // key is confirmed "state"
            ->filter()
            ->sort()
            ->values();

        return response()->json($states);
    }

    public function getLgas($state)
    {
        $data = $this->fetchData();

        $entry = collect($data)->first(function ($item) use ($state) {
            return strtolower(trim($item['state'])) === strtolower(trim($state));
        });

        if (!$entry) {
            return response()->json([]);
        }

        // Extract just the LGA names from the nested objects
        $lgas = collect($entry['lgas'])
            ->pluck('name')        // each LGA is {"name": "Aba North", "wards": [...]}
            ->filter()
            ->sort()
            ->values();

        return response()->json($lgas);
    }
}