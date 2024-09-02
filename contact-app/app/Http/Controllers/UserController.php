<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
    * @OA\Post(path="/api/v1/user",
    *     tags={"Usuário"},
    *     summary="Criar novo usuário",
    *     operationId="createUser",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                  @OA\Property(property="name", type="string"),
    *                  @OA\Property(property="email", type="string"),
    *                  @OA\Property(property="password", type="string"),
    *                  required={"name", "email", "password"}
    *             )
    *         )
    *      ),
    *     @OA\Response(response="401", description="Usuário criado com sucesso"),
    *     @OA\Response(response="422", description="Campos inválidos")
    * )
    */
    public function store(Request $request)
    {
        $data = $this->userService->createUser($request);
        return response()->json($data['message'], $data['status']);
    }

    /**
    * @OA\Delete(path="/api/v1/user",
    *     tags={"Usuário"},
    *     summary="Excluir usuário",
    *     operationId="deleteUserByPassword",
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
    *     @OA\Response(response="204", description="Usuário excluído com sucesso"),
    *     @OA\Response(response="400", description="O campo senha é obrigatório"),
    *     @OA\Response(response="404", description="Senha inválida!"),
    *     security={{ "apiAuth": {} }}
    * )
    */
    public function destroy(Request $request)
    {
        $data = $this->userService->deleteUserByPassword($request);
        return response()->json($data['message'], $data['status']);
    }

    /**
    * @OA\Post(path="/api/v1/recover",
    *     tags={"Usuário"},
    *     summary="Recuperar usuário por email cadastrado",
    *     operationId="getPasswordByEmail",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                  @OA\Property(property="email", type="string"),
    *                  required={"email"}
    *             )
    *         )
    *      ),
    *     @OA\Response(response="204", description="Recuperação de senha enviada no e-mail cadastrado"),
    *     @OA\Response(response="400", description="O campo e-mail é obrigatório"),
    *     @OA\Response(response="404", description="Usuário não encontrado!"),
    * )
    */
    public function recover(Request $request) {
        $data = $this->userService->getPasswordByEmail($request);
        return response()->json($data['message'], $data['status']);
    }

    /**
    * @OA\Post(path="/api/v1/user/logout",
    *     tags={"Usuário"},
    *     summary="Fazer o logout",
    *     operationId="logoutUser",
    *     @OA\Response(response="200", description="Usuário Deslogado!"),
    *     security={{ "apiAuth": {} }}
    * )
    */
    public function logout() {
        return $this->userService->logoutUser();
    }
}
