<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\EmpresasController;


//---------------------Login (Pública)-----------------
// Esta ruta es para iniciar sesión y no requiere autenticación previa.
Route::post('/login', [AuthController::class, 'login'])->name('login');

//-----------------------------------------------------
// RUTAS PÚBLICAS (NO REQUIEREN AUTENTICACIÓN)
// Todas las operaciones GET son públicas para mostrar información.
//-----------------------------------------------------

//---------------------Productos (Públicas)-----------------
Route::get('/productos/{id}', [ProductosController::class, "indexfilter"]);
Route::get('/productos', [ProductosController::class, "index"]);

//---------------------Empresas (Públicas)-----------------
Route::get("/empresas", [EmpresasController::class, "index"]);
Route::get("/empresas/buscar/{id}", [EmpresasController::class, "buscar"]);
Route::get('/empresas/filtrar/{colum}/{value}', [EmpresasController::class, 'filter']);

//---------------------Categorias (Públicas)-----------
Route::get("/categorias", [CategoriasController::class, "index"]);
Route::get("/categoriasfiltrar", [CategoriasController::class, "indexfilter"]);
Route::get("/categorias/buscar/{id}",[CategoriasController::class,"buscar"]); 

//---------------------Usuarios (Públicas - Solo Lectura)-----------------
Route::get('/usuarios',[UserController::class,'index']);
Route::get('/usuarios/buscar/{id}', [UserController::class, 'search']);
Route::get('/usuarios/filtrar/{colum}/{value}', [UserController::class, 'filter']);

//---------------------Ventas (Públicas - Solo Lectura)-----------------
Route::get('/ventas',[VentaController::class,'index']);
Route::get('/ventas/buscar/{id}', [VentaController::class, 'search']);
Route::get('/ventas/filtrar/{colum}/{value}', [VentaController::class, 'filter']);

//---------------------Promociones (Públicas - Solo Lectura)-----------------
Route::get('/promociones',[PromocionController::class,'index']);
Route::get('/promociones/buscar/{id}', [PromocionController::class, 'search']);
Route::get('/promociones/filtrar/{colum}/{value}', [PromocionController::class, 'filter']);

//---------------------Detalles de la ventas (Públicas - Solo Lectura)-----------------
Route::get('/detalleventa',[DetalleVentaController::class,'index']);
Route::get('/detalleventa/buscar/{id}', [DetalleVentaController::class, 'search']);
Route::get('/detalleventa/filtrar/{colum}/{value}', [DetalleVentaController::class, 'filter']);


//-----------------------------------------------------
// GRUPO DE RUTAS PROTEGIDAS POR AUTENTICACIÓN (Sanctum)
// Todas las rutas dentro de este grupo requieren un token de Sanctum válido.
//-----------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {

    //---------------------Cerrar sesión (Requiere autenticación)-----------------
    Route::post('/logout', [AuthController::class, 'logout']);

    //-----------------------------------------------------
    // RUTAS CON PERMISOS POR ROL (ADMIN)
    // Estas rutas solo son accesibles por usuarios con el rol 'admin'.
    //-----------------------------------------------------

    //---------------------Categorias (Solo Admin para CUD)-----------
    Route::middleware('role:admin')->group(function () {
        Route::post("/categorias",[CategoriasController::class,"crear"]);
        Route::post("/categorias/actualizar/{categoria}", [CategoriasController::class, "actualizar"]);
        Route::delete('/categorias/eliminar/{id}', [CategoriasController::class, 'delete']);
    });

    //---------------------Empresas (Solo Admin para CUD)------------
    Route::middleware('role:admin')->group(function () {
        Route::post("/empresas",[EmpresasController::class,"crear"]);
        Route::post("/empresas/actualizar/{empresas}", [EmpresasController::class, "actualizar"]);
        Route::delete('/empresas/eliminar/{id}', [EmpresasController::class, 'delete']);
    });


    //-----------------------------------------------------
    // RUTAS QUE SOLO REQUIEREN AUTENTICACIÓN (Cualquier usuario autenticado)
    // Estas rutas son accesibles por cualquier usuario que tenga un token válido.
    //-----------------------------------------------------

    //---------------------Productos (Solo Autenticación para CUD)-----------------
    Route::post("/productos",[ProductosController::class,"crear"]);
    Route::put("/productos/actualizar/{id}", [ProductosController::class, "actualizar"]); // Asumiendo que tienes esta ruta de actualización
    Route::delete('/productos/eliminar/{id}', [ProductosController::class, 'delete']);

    //---------------------Usuarios (Solo Autenticación para CUD)-----------------
    Route::post('/usuarios/crear', [UserController::class, 'store']);
    Route::put('/usuarios/actualizar/{usuario}', [UserController::class, 'update']);
    Route::delete('/usuarios/eliminar/{id}', [UserController::class, 'delete']);

    //---------------------Ventas (Solo Autenticación para CUD)-----------------
    Route::post('/ventas/crear', [VentaController::class, 'store']);
    Route::put('/ventas/actualizar/{id}', [VentaController::class, 'update']);
    Route::delete('/ventas/eliminar/{id}', [VentaController::class, 'delete']);

    //---------------------Promociones (Solo Autenticación para CUD)-----------------
    Route::post('/promociones/crear', [PromocionController::class, 'store']);
    Route::post('/promociones/actualizar/{id}', [PromocionController::class, 'update']);
    Route::delete('/promociones/eliminar/{id}', [PromocionController::class, 'delete']);

    //---------------------Detalles de la ventas (Solo Autenticación para CUD)-----------------
    Route::post('/detalleventa/crear', [DetalleVentaController::class, 'store']);
    Route::put('/detalleventa/actualizar/{id}', [DetalleVentaController::class, 'update']);
    Route::delete('/detalleventa/eliminar/{id}', [DetalleVentaController::class, 'delete']);

});