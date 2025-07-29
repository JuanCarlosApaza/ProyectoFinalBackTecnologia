<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Producto;
use Illuminate\Validation\ValidationException;

class ProductosController extends Controller
{

    public function indexfilter($id)
    {
        $productos = Producto::with(['empresa', 'categoria'])->where("id_categoria", "{$id}")->get();
        return response()->json($productos, 200);
    }

    public function index()
    {
        $productos = Producto::with(["categoria", "empresa"])->orderBy("descuento","desc")->where("estado","stock")->get();
        return response()->json($productos, 200);
    }
    public function indexAdmin()
    {
        $productos = Producto::with(["categoria", "empresa"])->get();
        return response()->json($productos, 200);
    }
    public function filter($colum, $value)
    {
        $allowed = ['id', 'id_categoria', 'id_empresa', 'cantidad', 'estado'];
        if (!in_array($colum, $allowed)) {
            return response()->json(['error' => 'Columna no permitida'], 400);
        }
        $producto = Producto::with(["categoria", "empresa"])->where($colum, $value)->get();
        if (!$producto) {
            return response()->json(['error' => 'no encontro'], 400);
        }
        return response()->json($producto);
    }

    public function crear(Request $request)
    {
        try {
            $request->validate([
                "nombre" => "required|string|max:255",
                "descripcion" => "required|string|max:255",
                "estado" => "required|string|max:255",
                "cantidad" => "required|integer",
                "descuento" => "nullable|integer",
                "precio" => "required|numeric",
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en productos",
                "errores" => $e->errors(),
            ], 422);
        }

        $rutaimagen = null;
        if ($request->hasFile("imagen")) {
            $rutaimagen = $request->file("imagen")->store("imagenes", "public");
        }
        $productos = Producto::create([
            "nombre" => $request->input(key: "nombre"),
            "imagen" => $rutaimagen,
            "id_empresa" => $request->input("id_empresa"),
            "id_categoria" => $request->input("id_categoria"),
            "precio" => $request->input("precio"),
            "cantidad" => $request->input("cantidad"),
            "descripcion" => $request->input("descripcion"),
            "descuento" => $request->input("descuento"),
            "estado" => $request->input("estado"),
        ]);
        return response()->json($productos, 200);
    }
    public function buscar($id)
    {
        $empresa = Producto::with(["categoria","empresa"])-> find($id);
        return response()->json($empresa);
    }
    public function actualizar(Request $request, $id)
    {
        try {
            $request->validate([
                "nombre" => "required|string|max:255",
                "descripcion" => "required|string|max:255",
                "estado" => "required|string|max:255",
                "cantidad" => "required|integer",
                "descuento" => "nullable|integer",
                "precio" => "required|numeric",
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en productos",
                "errores" => $e->errors(),
            ], 422);
        }

        try {
            $producto = Producto::findOrFail($id);

            if ($request->hasFile("imagen")) {
                $rutaimagen = $request->file("imagen")->store("imagenes", "public");
                $producto->imagen = $rutaimagen;
            }

            $producto->nombre = $request->input("nombre");
            $producto->id_empresa = $request->input("id_empresa");
            $producto->id_categoria = $request->input("id_categoria");
            $producto->precio = $request->input("precio");
            $producto->cantidad = $request->input("cantidad");
            $producto->descripcion = $request->input("descripcion");
            $producto->descuento = $request->input("descuento");
            $producto->estado = $request->input("estado");

            $producto->save();

            return response()->json([
                "mensaje" => "Producto actualizado correctamente",
                "producto" => $producto
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "error" => "Error al actualizar producto: " . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $categoria = Producto::findOrFail($id);
            $categoria->delete();

            return response()->json(['mensaje' => 'Usuario eliminado correctamente'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperado: ' . $e->getMessage()], 500);
        }
    }
   public function BuscarProducto($id)
{
    try {
        $productos = Producto::with(["categoria", "empresa"])
            ->where("estado", "stock")
            ->where("nombre", "like", "%{$id}%")
            ->get();

        if ($productos->isEmpty()) {
            return response()->json([
                "mensaje" => "No se encontraron productos con ese nombre."
            ], 404);
        }

        return response()->json($productos, 200);

    } catch (\Exception $e) {
        return response()->json([
            "mensaje" => "Error al buscar productos.",
            "error" => $e->getMessage()
        ], 500);
    }
}

}
