<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Sucursale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductAdminController extends Controller
{

    public function __contruct()
    {
       $this->middleware(['auth:sanctum','role:Admin'])->only(['sucursalProductUpdate']);
    }

    public function sucursalProducts(Sucursale $sucursale)
    {
        $products = $sucursale->products;
        if ($products) {
            foreach ($products as $product) {
                $product->groups = $product->groups;
                $product->category=$product->category;
            }
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$products],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'products_inexistente'],400);
        }
    }

    public function sucursalProduct(Sucursale $sucursale, $productId)
    {
        $products=$sucursale->products->where('id',$productId)->first();
        if ($products) {
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$products],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'product_inexistente'],400);
        }
    }

    public function sucursalProductUpdate(Sucursale $sucursale, $productId, Request $request)
    {
        $validator = Validator::make($request->all(),['activated'=>'required|boolean']);
        
        if (!$validator->fails()) {
            $product=$sucursale->products->where('id',$productId)->first();
            if ($product) {
                $product->pivot->activated = $request->activated; 
                $product->pivot->save(); 
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'actualizado' ],200);
            }else{
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_inexistente' ],200);
            }
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=> $validator->errors()],400);
        }
    }
}
