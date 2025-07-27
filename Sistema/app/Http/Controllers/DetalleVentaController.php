<?php

namespace App\Http\Controllers;

use App\Models\Detalle_Venta;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DetalleVentaController extends Controller
{
    public function index()
    {
        $DetalleVenta = Detalle_Venta::with('venta.usuario', 'producto')->orderBy('id_venta', 'asc')->get();

        return response()->json($DetalleVenta);
    }

    public function search($id)
    {
        $DetalleVenta = Detalle_Venta::findOrFail($id);

        return response()->json(['Detalles de la Venta encontrados' => $DetalleVenta], 200);
    }

    public function filter($colum, $value)
    {
        $allowed = ['id', 'id_producto', 'id_venta', 'cantidad', 'estado'];
        if (!in_array($colum, $allowed)) {
            return response()->json(['error' => 'Columna no permitida'], 400);
        }

        $detalle = Detalle_Venta::where($colum, $value)->with(['producto', 'venta'])->first();

        if (!$detalle) {
            return response()->json(['message' => 'No se encontró detalle de venta'], 404);
        }

        return response()->json($detalle);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
            'cantidad' => 'required|integer|min:1',
            'id_producto' => 'required|exists:productos,id',
            'id_venta' => 'required|exists:ventas,id',
            'estado' => 'required|string|max:255',
        ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación detalle venta",
                "errores" => $e->errors(),
            ], 422);
        }
        
        $DetalleVenta = Detalle_Venta::create($request->all());

        return response()->json(['Detalles venta creada' => $DetalleVenta], 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
            'cantidad' => 'required|integer|min:1',
            'id_producto' => 'required|exists:productos,id',
            'id_venta' => 'required|exists:ventas,id',
            'estado' => 'required|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación detalle venta",
                "errores" => $e->errors(),
            ], 422);
        }

        $DetalleVenta = Detalle_Venta::create($request->all());

        return response()->json(['Detalles de la venta actualizada' => $DetalleVenta], 200);
    }

    public function delete($id)
    {
        try {
            $detalleVenta = Detalle_Venta::findOrFail($id);
            $detalleVenta->delete();

            return response()->json(['mensaje' => 'Detalles de la venta eliminada correctamente'], 200);

        }catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperado: ' . $e->getMessage()], 500);
        }
    }

}
