<?php

namespace App\Http\Controllers;

use App\Models\Sucursale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SucursalController extends Controller
{

    public function __contruct()
    {
       $this->middleware(['auth:sanctum','role:SuperAdmin'])->only(['store','update','destroy']);
    }
    public function index()
    {
        $sucursales = DB::table('sucursales')->select('sucursales.*','cities.name as city_name')->join('cities','sucursales.city_id','=','cities.id')->get();
        return response()->json([
            'status' => true,
            'codigo_http' => 200,
            'data' => $sucursales
        ],200);
    }

    public function store(Request $request)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesSucursale());

        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            Sucursale::create($request->all());

            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'sucursales_agregadas'],200);
        }
    }

    public function show($id)
    {
        $sucursale = Sucursale::find($id);
        if(isset($sucursale)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$sucursale],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'sucursal_inexistente'],404);
        }
    }

    public function update(Request $request, $id)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesSucursale());

        if ($validator->fails()) {
            //se retorna la respuesta con los errores
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se busca la existencia del producto
            $sucursale=Sucursale::find($id);
            if (isset($sucursale)) {
                //Se modifican los datos
                $sucursale->name=$request->name;
                $sucursale->city_id=$request->city_id;
    
                //Guarda el registro
                $sucursale->save();
    
                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'sucursal_inexistente'],404);
            }
        }
    }


    public function destroy($id)
    {
        //Se busca la existencia del producto
        $sucursale = Sucursale::find($id);
        if (isset($sucursale)) {
            //Si existe lo elimina
            $sucursale->delete();
            //Se retorna una respuesta exitosa
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'sucursal_eliminada'],200);
        }else{
            //Si no existe
            return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'sucursal_inexistente'],404);
        }
    }

    
    //Rules to Validators
    public function rulesSucursale()
    {
        return [
            'name'=>'required|min:3',
            'city_id' => 'required|exists:cities,id'
        ];
    }
}
