<?php

namespace App\Http\Controllers;

use App\Models\Detalle_Venta;
use Illuminate\Http\Request;

class DetalleVentaController extends Controller
{
    public function index(){
        $DetalleVenta = Detalle_Venta::all();

        return response()->json($DetalleVenta);
    }

    public function search($id){
        $DetalleVenta = Detalle_Venta::findOrFail($id);

        return response()->json(['Detalles de la Venta encontrados' => $DetalleVenta], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'id_producto' => 'required|exists:productos,id',
            'id_venta' => 'required|exists:ventas,id',
            'estado' => 'required|string|max:255',
        ]);

        $DetalleVenta = Detalle_Venta::create($request->all());

        return response()->json(['Detalles venta creada' => $DetalleVenta], 201);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'id_producto' => 'required|exists:productos,id',
            'id_venta' => 'required|exists:ventas,id',
            'estado' => 'required|string|max:255',
        ]);

        $DetalleVenta = Detalle_Venta::create($request->all());

        return response()->json(['Detalles de la venta actualizada' => $DetalleVenta], 200);
    }
    
    public function delete($id)
    {
        $DetalleVenta = Detalle_Venta::findOrFail($id);
        $DetalleVenta->delete();

        return response()->json(['mensaje' => 'Detalles de la venta eliminada correctamente'], 200);
    }
}
