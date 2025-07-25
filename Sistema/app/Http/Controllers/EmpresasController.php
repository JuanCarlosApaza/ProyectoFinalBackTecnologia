<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Empresa;

class EmpresasController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }
    public function crear(Request $request)
    {
        $request->validate([
            "nombre" => "required|string",
            "direccion" => "required|string",
            "telefono" => "required|string",
            "estado"=> "required|string",

        ]);
        $rutaimagen=null;
        if($request->hasFile("logo")){
            $rutaimagen = $request->file("logo")->store("imagenes","public");
        }
        $empresa = Empresa::create([   
            "nombre"=>$request->input("nombre"),
            "logo"=>$rutaimagen,
            "direccion"=>$request->input("direccion"),
            "telefono"=>$request->input("telefono"),
            "estado"=>$request->input("estado"),
         ]);
         return response()->json($empresa);
    }
}
