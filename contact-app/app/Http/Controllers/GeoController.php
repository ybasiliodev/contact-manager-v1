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
        $headers = [
            "Content-type" => "image/png",
            "Content-Disposition" => "attachment; filename=map.png",
            "Access-Control-Expose-Headers" => "Content-Disposition",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
          ];
        $data = $this->geoService->getMap($request);
        return response()->stream(function() use($data){
            $file = fopen('php://output', 'w');
            fwrite($file, $data);
            fclose($file);
          }, 200, $headers);
    }
}
