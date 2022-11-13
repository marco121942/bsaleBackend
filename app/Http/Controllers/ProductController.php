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
        #Obtenemos todos los productos de la tabla PRODUCT
        $product = DB::table('product')
            ->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')
            ->get();
        #Modificamos el resultado según lo que el front necesite
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

        #Si no existe ningún error mandamos el resultado
        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Listado de productos',
                'data' =>  $product
            ], 200);
        }
        #Si  existe algún error mandamos un mensaje con un estado de error
        return response()->json([
            'success' => false,
            'message' => 'ocurrió algo inesperado',
            'data' => null
        ], 400);
    }

    public function getProductCategory()
    {
        #Realizamos una consulta desde la relación  'products',ya que es el que une la tabla CATEGORY con la tabla PRODUCT y asi obtener los productos clasificados por su categoría
        $product = Category::with('products')->get();


        #Modificamos el resultado según lo que el front necesite
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

        #Si no existe ningún error mandamos el resultado

        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Listado de productos por categoría',
                'data' =>  $product
            ], 200);
        }
        #Si  existe algún error mandamos un mensaje con un estado de error
        return response()->json([
            'success' => false,
            'message' => 'ocurrió algo inesperado',
            'data' => null
        ], 400);
    }
    public function searchProduct(Request $request)
    {
        #Ejecutamos la siguiente consulta, la cual tiene como finalidad comparar el nombre del producto con la palabra clave que es enviada por el FRONT
        $resultado = Product::where('name', 'like', '%' . $request->keyword . '%')->get();
        #Modificamos el resultado según lo que el front necesite
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
        #Si no existe ningún error mandamos el resultado
        return response()->json([
            'success' => true,
            'message' => 'Resultado de la búsqueda',
            'data' =>  $resultado
        ], 200);
    }
    public function filterProduct(Request $request)
    {


        //  start - Según las características que es enviada por el FRONT para el filtrado de productos,comparamos y ejecutamos el Query correcto para el filtrado
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
        if ($request->typeFilter === 'discount') {
            if ($request->dataFilter == 0) {
                $dataProduct = Product::where('discount', '=', 0)->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')->get();
            } else if ($request->dataFilter == 1) {
                $dataProduct = Product::where('discount', '>', 0)->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')->get();
            }
        }
        if ($request->typeFilter === 'imagen') {
            if ($request->dataFilter == 0) {
                $dataProduct = Product::whereNull('url_image')->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')->get();
            } else if ($request->dataFilter == 1) {
                $dataProduct = Product::whereNotNull('url_image')->join('category', 'category.id', '=', 'product.category')->select('product.*', 'category.name as name_category')->get();
            }
        }
        //  end - Según las características que es enviada por el FRONT para el filtrado de productos,comparamos y ejecutamos el Query correcto para el filtrado
        #Modificamos el resultado según lo que el front necesite
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
        #Si no existe ningún error mandamos el resultado
        return response()->json([
            'success' => true,
            'message' => 'Resultados del filtro',
            'data' =>  $dataProduct
        ], 200);
    }
}
