<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        return response()->json([
            'status' => true,
            'codigo_http' => 200,
            'data' => $sales
        ],200);
    }

    public function store(Request $request)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesSale());

        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            Sale::create($request->all());

            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'ventas_agregadas'],200);
        }
    }

    public function show($id)
    {
        $sale = Sale::find($id);
        if(isset($sale)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$sale],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'venta_inexistente'],404);
        }
    }

    public function update(Request $request, $id)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesSale());

        if ($validator->fails()) {
            //se retorna la respuesta con los errores
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se busca la existencia del producto
            $sale=Sale::find($id);
            if (isset($sale)) {
                //Se modifican los datos
                $sale->shipping_address=$request->shipping_address;
                $sale->phone=$request->phone;
                $sale->total=$request->total;
                $sale->observation=$request->observation;
                $sale->user_id=$request->user_id;
                $sale->sucursale_id=$request->sucursale_id;
                $sale->state_id=$request->state_id;
    
                //Guarda el registro
                $sale->save();
    
                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'venta_inexistente'],404);
            }
        }
    }

    public function destroy($id)
    {
        //Se busca la existencia del producto
        $sale = Sale::find($id);
        if (isset($sale)) {
            //Si existe lo elimina
            $sale->delete();
            //Se retorna una respuesta exitosa
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'venta_eliminada'],200);
        }else{
            //Si no existe
            return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'venta_inexistente'],404);
        }
    }

    public function rulesSale()
    {
        return [
            'shipping_address' => 'required|min:3',
            'phone' => 'required|integer|between:1:9999999999',
            'total' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'sucursale_id' => 'required|exists:sucursales,id',
            'state_id' => 'required|exists:states,id'
        ];
    }
}
