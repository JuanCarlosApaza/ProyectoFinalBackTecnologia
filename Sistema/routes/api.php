<?php

use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriasController;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//---------------------Prodcutos-----------------
Route::get('/productos/{id}',action: [ProductosController::class,"indexfilter"]);
Route::get('/productos',action: [ProductosController::class,"index"]);
Route::post("/productos",[CategoriasController::class,"crear"]);

// ----------Categorias-----------
Route::get("/categorias",[CategoriasController::class,"index"]);
Route::get("/categoriasfiltrar",[CategoriasController::class,"indexfilter"]);
Route::post("/categorias",[CategoriasController::class,"crear"]);
//------------Empresas
Route::get("/empresas",[CategoriasController::class,"index"]);
Route::post("/empresas",[CategoriasController::class,"crear"]);
