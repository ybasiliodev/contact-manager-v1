<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeoService;

class GeoController extends Controller
{
    public function __construct(GeoService $geoService)
    {
        $this->geoService = $geoService;
    }

    public function showAddress($postalCode) {
        $data = $this->geoService->getAddressData($postalCode);
        return response()->json($data['data'], $data['status']);
    }

    public function showCordinates(Request $request) {
        $data = $this->geoService->getGeoData($request);
        return response()->json($data['data'], $data['status']);
    }

    public function showMap(Request $request) {
        $data = $this->geoService->getMap($request);
        
        if ($data['status'] == 200) {
            return response()->stream(function() use($data){
                $file = fopen($data['folder'], 'w');
                fwrite($file, $data['map']);
                fclose($file);
            }, $data['status'], $data['headers']);
        }
        
        return response()->json($data['data'], $data['status']);
    }
}
