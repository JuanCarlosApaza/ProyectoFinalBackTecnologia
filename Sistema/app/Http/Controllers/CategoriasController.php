<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Categoria;
class CategoriasController extends Controller
{
    public function index(){
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
    public function indexfilter(){
        $categorias = Categoria::where("estado",true)->get();
        return response()->json($categorias);
    }
    public function crear(Request $request){
        $request->validate([
            "nombre" =>"required|string|max:255",
            "estado"=>"required|boolean",
        ]);
        $rutaimagen=null;
        if($request->hasFile("imagen")){
            $rutaimagen = $request->file("imagen")->store("imagenes","public");
        }
        $categoria =Categoria::create([
            "nombre"=> $request->input("nombre"),
            "estado"=>$request->input("estado"),
            "imagen"=>$rutaimagen,
        ]);
        return response()->json($categoria);

    }
}
