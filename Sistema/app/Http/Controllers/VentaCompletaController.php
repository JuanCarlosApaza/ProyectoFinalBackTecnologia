<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Detalle_Venta;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class VentaCompletaController extends Controller
{
    public function completa(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'metodo_pago' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
                'id_usuario' => 'required|exists:users,id',
                'total' => 'required|numeric',
                'detalles' => 'required|array|min:1',
                'detalles.*.id_producto' => 'required|exists:productos,id',
                'detalles.*.cantidad' => 'required|integer|min:1',
                'detalles.*.estado' => 'required|string|max:255',
            ]);

            $venta = Venta::create([
                'metodo_pago' => $request->metodo_pago,
                'estado' => $request->estado,
                'id_usuario' => $request->id_usuario,
                'total' => $request->total
            ]);

            foreach ($request->detalles as $detalle) {
                $producto = Producto::find($detalle['id_producto']);

                if ($producto->cantidad < $detalle['cantidad']) {
                    DB::rollBack();
                    return response()->json([
                        'error' => 'Stock insuficiente para el producto: ' . $producto->nombre
                    ], 400);
                }

                $producto->cantidad -= $detalle['cantidad'];
                $producto->save();


                Detalle_Venta::create([
                    'id_venta' => $venta->id,
                    'id_producto' => $detalle['id_producto'],
                    'cantidad' => $detalle['cantidad'],
                    'descuento' => $detalle['descuento'] ?? 0,
                    'estado' => $detalle['estado']
                ]);
            }

            DB::commit();
            return response()->json(['mensaje' => 'Venta completa registrada', 'venta_id' => $venta->id], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al registrar venta',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }
}
