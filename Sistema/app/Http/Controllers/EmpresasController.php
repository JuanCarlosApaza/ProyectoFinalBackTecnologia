<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Empresa;
use Illuminate\Validation\ValidationException;

class EmpresasController extends Controller
{
    public function index()
    {
        $empresas = Empresa::where('estado', "Activo")->get();
        return response()->json($empresas);
    }
    public function indexAdmin()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    public function filter($colum, $value)
    {

        $allowed = ['id', 'nombre', 'direccion', 'telefono', 'estado'];
        if (!in_array($colum, $allowed)) {
            return response()->json(['error' => 'Columna no permitida'], 400);
        }

        $empresa = Empresa::where($colum, $value)->with('productos')->get();

        if (!$empresa) {
            return response()->json(['message' => 'No se encontró empresa'], 404);
        }

        return response()->json($empresa);
    }
//  public function indexTrue()
// {
//     try {
//         $empresas = Empresa::where('estado', 'Activo')->get(); 

//         return response()->json([
//             'mensaje' => 'Empresas activas obtenidas correctamente',
//             'empresas' => $empresas
//         ], 200);
//     } catch (\Exception $e) {
//         return response()->json([
//             'mensaje' => 'Error al obtener las empresas activas',
//             'error' => $e->getMessage()
//         ], 500);
//     }
// }

    public function crear(Request $request)
    {
        try {
            $request->validate([
                "nombre" => "required|string",
                "direccion" => "required|string",
                "texto" => "required|string",
                "fondo" => "required|string",
                "telefono" => "required|string",
                "estado" => "required|string",

            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en empresas",
                "errores" => $e->errors(),
            ], 422);
        }

        $rutaimagen = null;

        if ($request->hasFile("logo")) {
            $rutaimagen = $request->file("logo")->store("imagenes", "public");
        }
        $empresa = Empresa::create([
            "nombre" => $request->input("nombre"),
            "logo" => $rutaimagen,
            "direccion" => $request->input("direccion"),
            "telefono" => $request->input("telefono"),
            "texto" => $request->input("texto"),
            "fondo" => $request->input("fondo"),
            "estado" => $request->input("estado"),
            "id_usuario" => $request->input("id_usuario"),
        ]);

        return response()->json($empresa);
    }

    public function buscar($id)
    {
        $empresa = Empresa::find($id);
        return response()->json($empresa);
    }

    public function actualizar(Request $request, $id)
    {
        $empresa = Empresa::find($id);
        try {
            $request->validate([
                "nombre" => "required|string",
                "direccion" => "required|string",
                "telefono" => "required|string",
                "estado" => "required|string",
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "mensaje" => "Errores de validación en empresas",
                "errores" => $e->errors(),
            ], 422);
        }

        if ($request->hasFile("logo")) {
            $rutaimagen = $request->file("logo")->store("imagenes", "public");
            $empresa->logo = $rutaimagen;
        }

        $empresa->nombre = $request->input("nombre");
        $empresa->direccion = $request->input("direccion");
        $empresa->telefono = $request->input("telefono");
        $empresa->estado = $request->input(key: "estado");
        $empresa->texto = $request->input(key: "texto");
        $empresa->fondo = $request->input(key: "fondo");

        $empresa->save();

        return response()->json($empresa);
    }

    public function delete($id)
    {
        try {
            $categoria = Empresa::findOrFail($id);
            $categoria->delete();

            return response()->json(['mensaje' => 'Usuario eliminado correctamente'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error inesperado: ' . $e->getMessage()], 500);
        }
    }
}
