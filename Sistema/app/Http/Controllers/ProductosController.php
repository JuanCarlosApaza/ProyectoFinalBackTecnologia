<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Producto;
class ProductosController extends Controller
{
    public function index($id){
    $productos = Producto::with(['empresa', 'categoria'])->where("id_categoria","{$id}")->get();
    return response()->json($productos, 200);
}

}
