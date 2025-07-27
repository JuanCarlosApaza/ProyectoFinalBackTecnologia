<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Categoria;
use Illuminate\Validation\ValidationException;

class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    public function indexfilter()
    {
        $categorias = Categoria::where("estado", true)->get();
        return response()->json($categorias);
    }

    public function crear(Request $request)
    {
        try {$request->validate([
            "nombre" => "required|string|max:255",
            "estado" => "required|boolean",
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación categorias",
                "errores" => $e->errors(),
            ], 422);
        }

        $rutaimagen = null;
        if ($request->hasFile("imagen")) {
            $rutaimagen = $request->file("imagen")->store("imagenes", "public");
        }
        $categoria = Categoria::create([
            "nombre" => $request->input("nombre"),
            "estado" => $request->input("estado"),
            "imagen" => $rutaimagen,
        ]);
        return response()->json($categoria);
    }

    public function buscar($id)
    {
        $categoria = Categoria::find($id);
        return response()->json($categoria);
    }

    public function actualizar(Request $request, $id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        try {$request->validate([
            "nombre" => "required|string|max:255",
            "estado" => "required|boolean",
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación categorias",
                "errores" => $e->errors(),
            ], 422);
        }

        if ($request->hasFile("imagen")) {
            $rutaimagen = $request->file("imagen")->store("imagenes", "public");
            $categoria->imagen = $rutaimagen;
        }

        $categoria->nombre = $request->input("nombre");
        $categoria->estado = $request->input("estado");
        $categoria->save();

        return response()->json($categoria);
    }

    public function delete($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();

            return response()->json(['mensaje' => 'Usuario eliminado correctamente'], 200);

        }catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperado: ' . $e->getMessage()], 500);
        }
    }
}
