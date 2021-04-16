<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index()
    {
        $cities = DB::table('cities')
            ->select('cities.*','sucursales.id as sucursale_id','sucursales.name as sucursale_name')
            ->join('sucursales','cities.id','=','sucursales.city_id')
            ->get();
        return response()->json([
            'status' => true,
            'codigo_http' => 200,
            'data' => $cities
        ],200);
    }

    public function store(Request $request)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesCity());

        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            City::create($request->all());

            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'ciudades_agregadas'],200);
        }
    }

    public function show($id)
    {
        $city = City::find($id);
        if(isset($city)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$city],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'ciudad_inexistente'],404);
        }
    }

    public function update(Request $request, $id)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesCity());

        if ($validator->fails()) {
            //se retorna la respuesta con los errores
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se busca la existencia del producto
            $city=City::find($id);
            if (isset($city)) {
                //Se modifican los datos
                $city->name=$request->name;
    
                //Guarda el registro
                $city->save();
    
                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'ciudad_inexistente'],404);
            }
        }
    }


    public function destroy($id)
    {
        //Se busca la existencia del producto
        $city = City::find($id);
        if (isset($city)) {
            //Si existe lo elimina
            $city->delete();
            //Se retorna una respuesta exitosa
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'ciudad_eliminada'],200);
        }else{
            //Si no existe
            return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'ciudad_inexistente'],404);
        }
    }

    public function rulesCity()
    {
        return [
            'name'=>'required|min:3'
        ];
    }
}
