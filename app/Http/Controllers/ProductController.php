<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class ProductController extends Controller
{
    //

    public function getProduct()
    {
        $product = DB::table('product')
            ->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')
            ->get();

        foreach ($product as $data) {

            if ($data->url_image == '') {
                $data->url_image = "https://www.bicifan.uy/wp-content/uploads/2016/09/producto-sin-imagen.png";
            }
            if ($data->discount == 0) {
                $data->discount = "Sin descuento";
            } else {
                $data->discount = "$" . $data->discount;
            }
            $data->price = "$" . $data->price;
        }


        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Listado de productos',
                'data' =>  $product
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'ocurrió algo inesperado',
            'data' => null
        ], 400);
    }

    public function getProductCategory()
    {

        $product = Category::with('products')->get();



        foreach ($product as $data) {
            foreach ($data->products as $item) {
                if ($item->url_image == '') {
                    $item->url_image = "https://www.bicifan.uy/wp-content/uploads/2016/09/producto-sin-imagen.png";
                }
                if ($item->discount == 0) {
                    $item->discount = "Sin descuento";
                } else {
                    $item->discount = "$" . $item->discount;
                }
                $item->price = "$" . $item->price;
            }
        }



        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Listado de productos por categoría',
                'data' =>  $product
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'ocurrió algo inesperado',
            'data' => null
        ], 400);
    }
    public function searchProduct(Request $request)
    {
        $resultado = Product::where('name', 'like', '%' . $request->keyword . '%')->get();

        foreach ($resultado as $data) {
            if ($data->url_image == '') {
                $data->url_image = "https://www.bicifan.uy/wp-content/uploads/2016/09/producto-sin-imagen.png";
            }
            if ($data->discount == 0) {
                $data->discount = "Sin descuento";
            } else {
                $data->discount = "$" . $data->discount;
            }
            $data->price = "$" . $data->price;
        }
        return response()->json([
            'success' => true,
            'message' => 'Resultado de la búsqueda',
            'data' =>  $resultado
        ], 200);
    }
    public function filterProduct(Request $request)
    {

     

        $typeFilter = "";
        if ($request->typeFilter === 'category') {
            $typeFilter = "category";
        } else if ($request->typeFilter === 'imagen') {
            $typeFilter = "url_image";
        } else if ($request->typeFilter === 'discount') {
            $typeFilter = "discount";
        }
        $dataProduct = "";
        if ($request->typeFilter === 'category') {
            $dataProduct = Product::where($typeFilter, $request->dataFilter)->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')->get();
        }
        if($request->typeFilter === 'discount'){
            if ($request->dataFilter == 0) {
                $dataProduct = Product::where('discount','=',0)->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')->get();
            } else if ($request->dataFilter == 1) {
                $dataProduct = Product::where('discount','>',0)->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')->get();
            }
        }
        if ($request->typeFilter === 'imagen') {
            if ($request->dataFilter == 0) {
                $dataProduct = Product::whereNull('url_image')->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')->get();
            } else if ($request->dataFilter == 1) {
                $dataProduct = Product::whereNotNull('url_image')->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')->get();
            }
        }

        foreach ($dataProduct as $data) {

            if ($data->url_image == '') {
                $data->url_image = "https://www.bicifan.uy/wp-content/uploads/2016/09/producto-sin-imagen.png";
            }
            if ($data->discount == 0) {
                $data->discount = "Sin descuento";
            } else {
                $data->discount = "$" . $data->discount;
            }
            $data->price = "$" . $data->price;
        }

        return response()->json([
            'success' => true,
            'message' => 'Resultados del filtro',
            'data' =>  $dataProduct
        ], 200);
    }
}
