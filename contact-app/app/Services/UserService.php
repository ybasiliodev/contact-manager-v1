<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;

class UserService
{
    public function __construct(AuthController $authController)
    {
        $this->authController = $authController;
    }

    public function getLoggedUserId() {
        return $this->authController->me()->getData()->id;
    }

    private function validateLoggedUserPassword($password) {
        return $this->authController->validateUser(["email" => $object->me()->getData()->email, "password" => $password]);
    }

    public function logoutUser() {
        return $this->authController->logout();
    }

    public function deleteUserByPassword(Request $request, User $user) {
        if (!$request->has('password')) {
            return ["message" => "O campo senha é obrigatório", "status" => 204];
        }

        if ($this->validateLoggedUserPassword($request->input('password'))) {
            $user = $user->find($this->getLoggedUserId());
            $user->delete();
            return ['message' => 'Usuário excluído com sucesso', "status" => 201];
        }

        return ['message' => 'Senha inválida!', "status" => 404];
    }

    public function getPasswordByEmail(Request $request, User $user) {
        if (!$request->has('email')) {
            return ["message" => "O campo e-mail é obrigatório", "status" => 204];
        }

        $user = $user->where('email', $request->input('email'))->get();

        if (!$user->isEmpty()) {
            return ['message' => 'recuperação de senha enviada no e-mail cadastrado', "status" => 201];
        }

        return ['message' => 'Usuário não encontrado', "status" => 404];
    }

    public function validateUserData(Request $request, User $user) {
        $request->validate($user->rulesUpdate(), $user->feedback());
    }
}
