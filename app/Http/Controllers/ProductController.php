<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::get();
    }

    public function store(Request $request)
    {
        $product=Product::create($request->all());

        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'productos_agregados'],200);
    }

    public function show($id)
    {
        return Product::find($id);
    }

    public function update(Request $request,Product $product)
    {
        $product->nombre=$request->nombre;
        $product->precio=$request->precio;
        $product->category_id=$request->category_id;
        
        $product->save();

        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);
    }
    
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_eliminado'],200);
    }
}
