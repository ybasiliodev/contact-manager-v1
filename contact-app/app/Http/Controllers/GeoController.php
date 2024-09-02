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

    /**
    * @OA\Get(path="/api/v1/geo/cordinates",
    *     tags={"GeoLocation"},
    *     summary="Buscar Endereço por cep",
    *     operationId="getAddressData",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                  @OA\Property(property="address", type="string"),
    *                  required={"address"}
    *             )
    *         )
    *      ),
    *     @OA\Response(response="200", description="Retorna as cordenadas"),
    *     @OA\Response(response="404", description="Endereço não encontrado"),
    *     security={{ "apiAuth": {} }}
    * )
    */
    public function showAddress($postalCode) {
        $data = $this->geoService->getAddressData($postalCode);
        return response()->json($data['data'], $data['status']);
    }

        /**
    * @OA\Get(path="/api/v1/geo/locate/{postal_code}",
    *     tags={"GeoLocation"},
    *     summary="Recupera a latitute e longitude do endereço digitado",
    *     operationId="getGeoData",
    *     @OA\Response(response="200", description="Retorna usuário"),
    *     @OA\Response(response="404", description="Endereço não encontrado"),
    *     security={{ "apiAuth": {} }}
    * )
    */
    public function showCordinates(Request $request) {
        $data = $this->geoService->getGeoData($request);
        return response()->json($data['data'], $data['status']);
    }

        /**
    * @OA\Get(path="/api/v1/geo/map",
    *     tags={"GeoLocation"},
    *     summary="Retorna um mapa com o pin marcado através da latitude e longitude",
    *     operationId="getMap",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                  @OA\Property(property="lat", type="string"),
    *                  @OA\Property(property="lon", type="string"),
    *                  required={"lat", "lon"}
    *             )
    *         )
    *      ),
    *     @OA\Response(response="200", description="Retorna imagem"),
    *     @OA\Response(response="404", description="Endereço não encontrado"),
    *     security={{ "apiAuth": {} }}
    * )
    */
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
