<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::all();

        return response()->json($users);
    }

    public function search($id){
        $usuario = User::findOrFail($id);

        return response()->json(['Usuario encontrado' => $usuario], 200);
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $data = $request->only(['name', 'email', 'password']);
    $data['password'] = bcrypt($data['password']);  
    $usuario = User::create($data);

    return response()->json(['Usuario' => $usuario], 201);
}


    public function update(Request $request,$id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8|confirmed',
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $usuario->update($data);

        return response()->json(['Usuario actualizado' => $usuario], 200);
    }
    
    public function delete($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return response()->json(['mensaje' => 'Usuario eliminado correctamente'], 200);
    }
}
