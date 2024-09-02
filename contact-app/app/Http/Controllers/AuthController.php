<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
    * @OA\SecurityScheme(
    *     type="http",
    *     description="Login with email and password to get the authentication token",
    *     name="Token based Based",
    *     in="header",
    *     scheme="bearer",
    *     bearerFormat="JWT",
    *     securityScheme="apiAuth",
        * )
    */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
    * @OA\Post(path="/api/v1/login",
    *     tags={"Autorização"},
    *     summary="Obter token por email e senha cadastrados",
    *     operationId="login",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                  @OA\Property(property="password", type="string"),
    *                  required={"password"}
    *             )
    *         )
    *      ),
    *     @OA\Response(response="200", description="access_token"),
    *     @OA\Response(response="401", description="Unauthorized"),
    * )
    */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function validateUser($credentials) {
        if (auth()->validate($credentials)) {
            return true;
        }
        return false;
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->invalidate(true);

        return response()->json('Usuário Deslogado!', 200);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
