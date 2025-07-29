<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

    public function filter($colum, $value)
    {
        $allowed = ['id', 'name','email'];
        if (!in_array($colum, $allowed)) {
            return response()->json(['error' => 'Columna no permitida'], 400);
        }

        $promo = User::with('ventas')->where($colum, $value)->first();

        if (!$promo) {
            return response()->json(['message' => 'No se encontró detalle de venta'], 404);
        }

        return response()->json($promo);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en usuarios",
                "errores" => $e->errors(),
            ], 422);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);  
        $usuario = User::create($data);

        return response()->json(['Usuario' => $usuario], 201);
    }

    public function update(Request $request,$id)
    {
        $usuario = User::findOrFail($id);

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en usuarios",
                "errores" => $e->errors(),
            ], 422);
        }

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $usuario->update($data);

        return response()->json(['Usuario actualizado' => $usuario], 200);
    }
    
    public function delete($id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->delete();

            return response()->json(['mensaje' => 'Usuario eliminado correctamente'], 200);

        }catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperado: ' . $e->getMessage()], 500);
        }
    }
}
