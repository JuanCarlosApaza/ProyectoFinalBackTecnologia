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
use App\Http\Controllers\VentaCompletaController;
use Illuminate\Http\Request;

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
Route::get("/productos/buscar/{id}", [ProductosController::class, "buscar"]);
Route::get('/productos/filtrar/{colum}/{value}', [ProductosController::class, "filter"]);
Route::get("/productos/search/{id}", [ProductosController::class, "BuscarProducto"]);

//---------------------Empresas (Públicas)-----------------
Route::get("/empresas", [EmpresasController::class, "index"]);
Route::get("/empresas/buscar/{id}", [EmpresasController::class, "buscar"]);
Route::get('/empresas/filtrar/{colum}/{value}', [EmpresasController::class, 'filter']);

//---------------------Categorias (Públicas)-----------
Route::get("/categorias", [CategoriasController::class, "index"]);
Route::get("/categoriasfiltrar/{colum}/{value}", [CategoriasController::class, "indexfilter"]);
Route::get("/categorias/buscar/{id}", [CategoriasController::class, "buscar"]);

//---------------------Usuarios (Públicas - Solo Lectura)-----------------
Route::get('/usuarios/buscar/{id}', [UserController::class, 'search']);
Route::get('/usuarios/filtrar/{colum}/{value}', [UserController::class, 'filter']);
Route::post('/usuarios/crear', [UserController::class, 'store']);


//---------------------Promociones (Públicas - Solo Lectura)-----------------
Route::get('/promociones', [PromocionController::class, 'index']);
Route::get('/promociones/buscar/{id}', [PromocionController::class, 'search']);
Route::get('/promociones/filtrar/{colum}/{value}', [PromocionController::class, 'filter']);




//-----------------------------------------------------
// GRUPO DE RUTAS PROTEGIDAS POR AUTENTICACIÓN (Sanctum)
// Todas las rutas dentro de este grupo requieren un token de Sanctum válido.
//-----------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/usuarios', [UserController::class, 'index']);

    //---------------------Cerrar sesión (Requiere autenticación)-----------------
    Route::post('/logout', [AuthController::class, 'logout']);

    //-----------------------------------------------------
    // RUTAS CON PERMISOS POR ROL (ADMIN)
    // Estas rutas solo son accesibles por usuarios con el rol 'admin'.
    //-----------------------------------------------------

    //---------------------Categorias (Solo Admin para CUD)-----------
    Route::middleware('role:admin')->group(function () {
        Route::get('/categoriasadmin', action: [CategoriasController::class, "indexAdmin"]);
        Route::post("/categorias", [CategoriasController::class, "crear"]);
        Route::post("/categorias/actualizar/{categoria}", [CategoriasController::class, "actualizar"]);
        Route::delete('/categorias/eliminar/{id}', [CategoriasController::class, 'delete']);
    });

    //---------------------Empresas (Solo Admin para CUD)------------
    Route::middleware('role:admin')->group(function () {
        Route::get('/empresasadmin', action: [EmpresasController::class, "indexAdmin"]);
        Route::post("/empresas/crear", [EmpresasController::class, "crear"]);
        Route::post("/empresas/actualizar/{empresas}", [EmpresasController::class, "actualizar"]);
        Route::delete('/empresas/eliminar/{id}', [EmpresasController::class, 'delete']);
    });
    //---------------------Prodcutos (Solo Admin para CUD)------------

    Route::middleware('role:admin')->group(function () {
        Route::get('/productosadmin', action: [ProductosController::class, "indexAdmin"]);

        Route::post("/productos", [ProductosController::class, "crear"]);
        Route::post("/productos/actualizar/{id}", [ProductosController::class, "actualizar"]); // Asumiendo que tienes esta ruta de actualización
        Route::delete('/productos/eliminar/{id}', [ProductosController::class, 'delete']);
    });
    //---------------------Detalle (Solo Admin para CUD)------------

    Route::middleware('role:admin')->group(function () {
        Route::get('/detalleventa', [DetalleVentaController::class, 'index']);
        Route::get('/detalleventa/buscar/{id}', [DetalleVentaController::class, 'search']);
        Route::get('/detalleventa/filtrar/{colum}/{value}', [DetalleVentaController::class, 'filter']);
        Route::post('/ventas/completa', [VentaCompletaController::class, 'completa']);
        //---------------------Detalles de la ventas (Solo Autenticación para CUD)-----------------
        Route::post('/detalleventa/crear', [DetalleVentaController::class, 'store']);
        Route::put('/detalleventa/actualizar/{id}', [DetalleVentaController::class, 'update']);
        Route::delete('/detalleventa/eliminar/{id}', [DetalleVentaController::class, 'delete']);

    });
    //---------------------Ventas (Solo Admin para CUD)------------

    Route::middleware('role:admin')->group(function () {
        //---------------------Ventas (Públicas - Solo Lectura)-----------------
        Route::get('/ventas', [VentaController::class, 'index']);
        Route::get('/ventas/buscar/{id}', [VentaController::class, 'search']);
        Route::get('/ventas/filtrar/{colum}/{value}', [VentaController::class, 'filter']);
    });
    //---------------------Usaurios (Solo Admin para CUD)------------

    Route::middleware('role:admin')->group(function () {
        Route::put('/usuarios/actualizar/{usuario}', [UserController::class, 'update']);
        Route::delete('/usuarios/eliminar/{id}', [UserController::class, 'delete']);
    });
    //---------------------Promociones (Solo Admin para CUD)------------

    Route::middleware('role:admin')->group(function () {
        //---------------------Promociones (Solo Autenticación para CUD)-----------------
        Route::post('/promociones/crear', [PromocionController::class, 'store']);
        Route::post('/promociones/actualizar/{id}', [PromocionController::class, 'update']);
        Route::delete('/promociones/eliminar/{id}', [PromocionController::class, 'delete']);
    });


    //-----------------------------------------------------
    // RUTAS QUE SOLO REQUIEREN AUTENTICACIÓN (Cualquier usuario autenticado)
    // Estas rutas son accesibles por cualquier usuario que tenga un token válido.
    //-----------------------------------------------------









});
