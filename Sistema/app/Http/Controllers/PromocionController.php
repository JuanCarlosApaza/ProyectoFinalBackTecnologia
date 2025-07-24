<?php

namespace App\Http\Controllers;

use App\Models\Promociones;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function index(){
        $promocion = Promociones::all();

        return response()->json($promocion);
    }

    public function search($id){
        $promocion = Promociones::findOrFail($id);

        return response()->json(['Promocion encontrada' => $promocion], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'imagen'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'estado' => 'required|boolean',
            'id_producto' => 'required|exists:productos,id',
        ]);

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

        $request->validate([
            'imagen'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'estado' => 'required|boolean',
            'id_producto' => 'required|exists:productos,id',
        ]);

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
        $promocion = Promociones::findOrFail($id);
        $promocion->delete();

        return response()->json(['mensaje' => 'Promocion eliminada correctamente'], 200);
    }
}
