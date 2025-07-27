<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(){
        $ventas = Venta::with("usuario")->get();

        return response()->json($ventas);
    }

    public function search($id){
        $venta = Venta::findOrFail($id);

        return response()->json(['Venta encontrada' => $venta], 200);
    }

    public function filter($colum, $value)
    {
        $allowed = ['id', 'metodo_pago','estado','total','id_usuario'];
        if (!in_array($colum, $allowed)) {
            return response()->json(['error' => 'Columna no permitida'], 400);
        }

        $promo = Venta::with('usuario','detalles')->where($colum, $value)->first();

        if (!$promo) {
            return response()->json(['message' => 'No se encontró detalle de venta'], 404);
        }

        return response()->json($promo);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'metodo_pago' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
                'id_usuario' => 'required|exists:users,id',
                'total' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en ventas",
                "errores" => $e->errors(),
            ], 422);
        }

        $venta = Venta::create($request->all());

        return response()->json(['Venta' => $venta], 201);
    }

    public function update(Request $request,$id)
    {
        $venta = Venta::findOrFail($id);

        try {
            $request->validate([
                'metodo_pago' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
                'id_usuario' => 'required|exists:users,id',
                'total' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en ventas",
                "errores" => $e->errors(),
            ], 422);
        }

        $venta->update($request->all());

        return response()->json(['Venta actualizada' => $venta], 200);
    }
    
    public function delete($id)
    {
        try {
            $venta = Venta::findOrFail($id);
            $venta->delete();

            return response()->json(['mensaje' => 'Venta eliminada correctamente'], 200);

        }catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperado: ' . $e->getMessage()], 500);
        }
    }
}
