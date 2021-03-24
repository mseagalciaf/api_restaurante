<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products= Product::get();
        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$products],200);
    }

    public function store(Request $request)
    {   
        //Reglas de validacion
        $rules = [
            'nombre'=>'required|min:3',
            'precio'=>'required|integer|min:1',
            'category_id'=>'required|exists:categories,id'
        ];
        //Se ejecuta la validacion con las reglas anteriores
        $validator = Validator::make($request->all(),$this->rulesProduct());
        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            Product::create($request->all());
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'productos_agregados'],200);
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        if(isset($product)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$product],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>200,'data'=>'producto_inexistente'],200);
        }
    }

    public function update(Request $request,Product $product)
    {
        //Reglas de validacion
        $rules = [
            'nombre'=>'required|min:3',
            'precio'=>'required|integer|min:1',
            'category_id'=>'required|exists:categories,id'
        ];
        //Se ejecuta la validacion con las reglas anteriores
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            Product::create($request->all());
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'productos_agregados'],200);
        }


        $product->nombre=$request->nombre;
        $product->precio=$request->precio;
        $product->category_id=$request->category_id;
        
        $product->save();

        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);
    }
    
    public function destroy($id)
    {
        $producto = Product::find($id);
        if (isset($producto)) {
            $producto->delete();
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_eliminado'],200);
        }else{
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_inexistente'],200);
        }
        
    }

    public function rulesProduct()
    {
        return [
            'nombre'=>'required|min:3',
            'precio'=>'required|integer|min:1',
            'category_id'=>'required|exists:categories,id'
        ];
    }
}
