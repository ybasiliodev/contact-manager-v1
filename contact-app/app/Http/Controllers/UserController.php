<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(User $user, UserService $userService)
    {
        $this->user = $user;
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $request->validate($this->user->rules(), $this->user->feedback());
        $user = $this->user->create($request->all());
        return response()->json(['status' => true,'data' => $user], 201);
    }

    public function destroy(Request $request)
    {
        $data = $this->userService->deleteUserByPassword($request, $this->user);
        return response()->json(['message' => $data['message']], $data['status']);
    }

    public function recover(Request $request) {
        $data = $this->userService->getPasswordByEmail($request, $this->user);
        return response()->json(['message' => $data['message']], $data['status']);
    }

    public function logout(Request $request) {
        return $this->userService->logoutUser();
    }
}
