<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class GeoService
{
    public function getGeoData(Request $request) {
        $response = Http::withQueryParameters([
            "address" => $request->input('address',''),
            "key" => config('custom.geo_key')
        ])
        ->withHeaders(['Content-Type' => 'application/json',])
        ->get('https://maps.googleapis.com/maps/api/geocode/json');

        if ($response->status() == 200) {
            $data = $response->json();
            $cordinates = $data['results'][0]['geometry']['location'];
            return ['data' => $cordinates, "status" => 200];
        }

        return ['data' => 'Endereço não encontrado', "status" => 404];
    }

    public function getMap(Request $request) {

        $cordinates = ["lat" => $request->input('lat',''),"lon" => $request->input('lon','')];

        $response = Http::withQueryParameters([
            "center" => "{$cordinates['lat']},{$cordinates['lon']}",
            "zoom" => $request->input('zoom','12'),
            "size" => $request->input('tamanho','400x400'),
            "markers" => "size:mid|color:red|{$cordinates['lat']},{$cordinates['lon']}",
            "key" => config('custom.geo_key')
        ])
        ->withHeaders(['Content-Type' => 'image/png',])
        ->get('https://maps.googleapis.com/maps/api/staticmap');

        if ($response->status() == 200) {
            $returnHeaders = [
                "Content-type" => "image/png",
                "Content-Disposition" => "attachment; filename=map.png",
                "Access-Control-Expose-Headers" => "Content-Disposition",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];

            return ["map" => $response->body(), "headers" => $returnHeaders, "folder" => 'php://output', "status" => 200];
        }

        return ['data' => 'Endereço não encontrado', "status" => 404];
    }


    public function getAddressData($postalCode) {
        $response = Http::acceptJson()->get("https://viacep.com.br/ws/$postalCode/json/");

        if ($response->status() == 200) {
            $response = $response->json();
            $data = [
                "address" => $response['logradouro'], 
                "district" => $response['bairro'], 
                "city" => $response['localidade'],
                "state" => $response['uf']
            ];

            return ['data' => $data, "status" => 200];
        }

        return ['data' => 'Endereço não encontrado', "status" => 404]; 
    }
}
