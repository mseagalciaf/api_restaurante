<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return response()->json([
            'status' => true,
            'codigo_http' => 200,
            'data' => $groups
        ],200);
    }

    public function store(Request $request)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesGroup());

        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            Group::create($request->all());

            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'grupos_agregadas'],200);
        }
    }

    public function show($id)
    {
        $group = Group::find($id);
        if(isset($group)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$group],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'grupo_inexistente'],404);
        }
    }

    public function update(Request $request, $id)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesGroup());

        if ($validator->fails()) {
            //se retorna la respuesta con los errores
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se busca la existencia del producto
            $group=Group::find($id);
            if (isset($group)) {
                //Se modifican los datos
                $group->name=$request->name;
    
                //Guarda el registro
                $group->save();
    
                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'grupo_inexistente'],404);
            }
        }
    }


    public function destroy($id)
    {
        //Se busca la existencia del producto
        $group = Group::find($id);
        if (isset($group)) {
            //Si existe lo elimina
            $group->delete();
            //Se retorna una respuesta exitosa
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'grupo_eliminada'],200);
        }else{
            //Si no existe
            return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'grupo_inexistente'],404);
        }
    }

    public function rulesGroup()
    {
        return [
            'name'=>'required|min:3'
        ];
    }
}

