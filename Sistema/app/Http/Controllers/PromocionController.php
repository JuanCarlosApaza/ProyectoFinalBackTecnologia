<?php

namespace App\Http\Controllers;

use App\Models\Promociones;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function index(){
        $promocion = Promociones::with("producto")->get();

        return response()->json($promocion);
    }

    public function search($id){
        $promocion = Promociones::findOrFail($id);

        return response()->json(['Promocion encontrada' => $promocion], 200);
    }

    public function filter($colum, $value)
    {
        $allowed = ['id', 'id_producto','estado'];
        if (!in_array($colum, $allowed)) {
            return response()->json(['error' => 'Columna no permitida'], 400);
        }

        $promo = Promociones::with('producto')->where($colum, $value)->first();

        if (!$promo) {
            return response()->json(['message' => 'No se encontró detalle de venta'], 404);
        }

        return response()->json($promo);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'imagen'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'estado' => 'required|boolean',
                'id_producto' => 'required|exists:productos,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en promociones",
                "errores" => $e->errors(),
            ], 422);
        }

        $datos=$request->all();
        
        if($request->hasFile('imagen')){
            $path=$request->file('imagen')->store('imagenes','public');
            $datos['imagen']=$path;
        }

        $promocion = Promociones::create($datos);

        return response()->json(['Promocion' => $promocion], 201);
    }

    public function update(Request $request,$id)
    {
        $promocion = Promociones::findOrFail($id);

        try {
            $request->validate([
                'imagen'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'estado' => 'required|boolean',
                'id_producto' => 'required|exists:productos,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en promociones",
                "errores" => $e->errors(),
            ], 422);
        }

        $datos=$request->all();
        
        if($request->hasFile('imagen')){
            $path=$request->file('imagen')->store('imagenes','public');
            $datos['imagen']=$path;
        }

        $promocion->update($datos);

        return response()->json(['Promocion actualizada' => $promocion], 200);
    }
    
    public function delete($id)
    {
        try {
            $promocion = Promociones::findOrFail($id);
            $promocion->delete();

            return response()->json(['mensaje' => 'Promocion eliminada correctamente'], 200);

        }catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperado: ' . $e->getMessage()], 500);
        }
    }
}
