<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Producto;

class ProductosController extends Controller
{

    public function indexfilter($id)
    {
        $productos = Producto::with(['empresa', 'categoria'])->where("id_categoria", "{$id}")->get();
        return response()->json($productos, 200);
    }
    public function index()
    {
        $productos = Producto::with(["categoria", "empresa"])->get();
        return response()->json($productos, 200);
    }
    public function crear(Request $request)
    {
        $request->validate([
            "nombre" => "required|string|max:255",
            "descripcion" => "required|string|max:255",
            "estado" => "required|string|max:255",
            "cantidad" => "required|integer",
            "descuento" => "nullable|integer",
            "precio" => "required|numeric",
        ]);
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
    }

}
