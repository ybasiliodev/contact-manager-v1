<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = $this->user->all();
        return response()->json(['status' => true,'data' => $user], 200);
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        return response()->json(['status' => true,'data' => $user], 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->user->rules(), $this->user->feedback());
        $user = $this->user->create($request->all());
        return response()->json(['status' => true,'data' => $user], 201);
    }

    public function update(Request $request, $id)
    {
        $user = $this->user->find($id);
        if($user === null) {
            return response()->json(['erro' => 'Usuário não encontrado'], 404);
        }
        $request->validate($this->user->rulesUpdate(), $this->user->feedback());
        $user->update($request->all());
        return response()->json(['status' => true,'data' => $user], 201);
    }

    public function destroy(Request $request)
    {
        $user = $this->user->find($id);
        if($user === null) {
            return response()->json(['erro' => 'Usuário não encontrado'], 404);
        }
        $user->delete();
        return response()->json(['status' => true,'data' => $user], 201);
    }
}
