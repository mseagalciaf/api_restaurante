<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:SuperAdmin')->only('destroy');
    }

    public function index()
    {
        $products= Product::get();
        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$products],200);
    }

    public function store(Request $request)
    {   
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesProduct());

        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            Product::create($request->all());

            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'productos_agregados'],200);
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        if(isset($product)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$product],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'producto_inexistente'],404);
        }
    }

    public function update(Request $request, $id)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesProduct());

        if ($validator->fails()) {
            //se retorna la respuesta con los errores
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se busca la existencia del producto
            $product=Product::find($id);
            if (isset($product)) {
                //Se modifican los datos
                $product->name=$request->name;
                $product->price=$request->price;
                $product->category_id=$request->category_id;
    
                //Guarda el registro
                $product->save();
    
                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'producto_inexistente'],404);
            }
        }
    }
    
    public function destroy($id)
    {
        //Se busca la existencia del producto
        $producto = Product::find($id);
        if (isset($producto)) {
            //Si existe lo elimina
            $producto->delete();
            //Se retorna una respuesta exitosa
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_eliminado'],200);
        }else{
            //Si no existe
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_inexistente'],200);
        }
        
    }

    public function rulesProduct()
    {
        return [
            'name'=>'required|min:3',
            'price'=>'required|integer|min:1',
            'category_id'=>'required|exists:categories,id'
        ];
    }
}
