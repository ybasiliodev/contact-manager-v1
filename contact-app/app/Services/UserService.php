<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;

class UserService
{
    public function __construct(AuthController $authController, User $user)
    {
        $this->user = $user;
        $this->authController = $authController;
    }

    public function getLoggedUserId() {
        return $this->authController->me()->getData()->id;
    }

    public function logoutUser() {
        return $this->authController->logout();
    }

    public function createUser(Request $request) {
        $request->validate($this->user->rules(), $this->user->feedback());
        $user = $this->user->create($request->all());

        return ['message' => 'Usuário criado com sucesso', "status" => 201];
    }

    public function deleteUserByPassword(Request $request) {
        if (!$request->has('password')) {
            return ["message" => "O campo senha é obrigatório", "status" => 400];
        }

        if ($this->validateLoggedUserPassword($request->input('password'))) {
            $user = $this->user->find($this->getLoggedUserId());
            $user->delete();
            return ['message' => 'Usuário excluído com sucesso', "status" => 204];
        }

        return ['message' => 'Senha inválida!', "status" => 404];
    }

    public function getPasswordByEmail(Request $request) {
        if (!$request->has('email')) {
            return ["message" => "O campo e-mail é obrigatório", "status" => 400];
        }

        $user = $this->user->where('email', $request->input('email'))->get();

        if (!$user->isEmpty()) {
            return ['message' => 'Recuperação de senha enviada no e-mail cadastrado', "status" => 200];
        }

        return ['message' => 'Usuário não encontrado', "status" => 404];
    }

    private function validateLoggedUserPassword($password) {
        return $this->authController->validateUser(["email" => $object->me()->getData()->email, "password" => $password]);
    }
}
