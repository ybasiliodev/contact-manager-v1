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

    public function store(Request $request)
    {
        $data = $this->userService->createUser($request, $this->user);
        return response()->json($data['message'], $data['status']);
    }

    public function destroy(Request $request)
    {
        $data = $this->userService->deleteUserByPassword($request, $this->user);
        return response()->json($data['message'], $data['status']);
    }

    public function recover(Request $request) {
        $data = $this->userService->getPasswordByEmail($request, $this->user);
        return response()->json($data['message'], $data['status']);
    }

    public function logout() {
        return $this->userService->logoutUser();
    }
}
