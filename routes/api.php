<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


#Servicio que tiene la finalidad de devvler todos los productos que existen en la BD
Route::get('/v1/get/product', [ProductController::class, 'getProduct']);
#Servicio encarga de devovler todos los productos clasificados según ala categoría ala que pertenece
Route::get('/v1/get/productCategory', [ProductController::class, 'getProductCategory']);
#Servicio encargado de devovler  los productos que coincidan con el nombre del producto,recive la palabra clave que es enviada por el FRONT 
Route::post('/v1/search/product', [ProductController::class, 'searchProduct']);
#Servicio encargado de devolver los productos filtrados por una característica que es enviada por el FRONT
Route::post('/v1/filter/product', [ProductController::class, 'filterProduct']);