<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sucursale;
use Illuminate\Http\Request;

class cartController extends Controller
{
    public function validateProducts(Request $request, Sucursale $sucursale)
    {
        $products= [];

        foreach ($request->products as $key) {
            $product = $sucursale->products->where('id',$key)->first();
            $product->groups = $product->groups;
            array_push($products,$product);
        }
        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$products],200);

    }
}
