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



Route::get('/v1/get/product', [ProductController::class, 'getProduct']);
Route::get('/v1/get/productCategory', [ProductController::class, 'getProductCategory']);
Route::post('/v1/search/product', [ProductController::class, 'searchProduct']);
Route::post('/v1/filter/product', [ProductController::class, 'filterProduct']);