<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

Route::get('/inicio/{id}',[ProductosController::class,"index"]);

//CURD usuarios
Route::get('/usuarios',[UserController::class,'index']);

Route::post('/usuarios/crear', [UserController::class, 'store']);

Route::get('/usuarios/buscar/{id}', [UserController::class, 'search']);

Route::put('/usuarios/actualizar/{usuario}', [UserController::class, 'update']);

Route::delete('/usuarios/eliminar/{id}', [UserController::class, 'delete']);

//CURD ventas
Route::get('/ventas',[VentaController::class,'index']);

Route::post('/ventas/crear', [VentaController::class, 'store']);

Route::get('/ventas/buscar/{id}', [VentaController::class, 'search']);

Route::put('/ventas/actualizar/{id}', [VentaController::class, 'update']);

Route::delete('/ventas/eliminar/{id}', [VentaController::class, 'delete']);

//CURD promociones
Route::get('/promociones',[PromocionController::class,'index']);

Route::post('/promociones/crear', [PromocionController::class, 'store']);

Route::get('/promociones/buscar/{id}', [PromocionController::class, 'search']);

Route::put('/promociones/actualizar/{id}', [PromocionController::class, 'update']);

Route::delete('/promociones/eliminar/{id}', [PromocionController::class, 'delete']);

//CURD Detalles de las ventas
Route::get('/detalleventa',[DetalleVentaController::class,'index']);

Route::post('/detalleventa/crear', [DetalleVentaController::class, 'store']);

Route::get('/detalleventa/buscar/{id}', [DetalleVentaController::class, 'search']);

Route::put('/detalleventa/actualizar/{id}', [DetalleVentaController::class, 'update']);

Route::delete('/detalleventa/eliminar/{id}', [DetalleVentaController::class, 'delete']);