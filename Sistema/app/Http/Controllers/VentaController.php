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

    public function store(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'id_usuario' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
        ]);

        $venta = Venta::create($request->all());

        return response()->json(['Venta' => $venta], 201);
    }

    public function update(Request $request,$id)
    {
        $venta = Venta::findOrFail($id);

        $request->validate([
            'metodo_pago' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'id_usuario' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
        ]);

        $venta->update($request->all());

        return response()->json(['Venta actualizada' => $venta], 200);
    }
    
    public function delete($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();

        return response()->json(['mensaje' => 'Venta eliminada correctamente'], 200);
    }
}
