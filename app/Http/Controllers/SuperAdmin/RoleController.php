<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'status' => true,
            'codigo_http' => 200,
            'data' => $roles
        ],200);
    }

    public function store(Request $request)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesRole());

        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            Role::create($request->all());

            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'roles_agregados'],200);
        }
    }

    public function show($id)
    {
        $role = Role::find($id);
        if(isset($role)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$role],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'role_inexistente'],404);
        }
    }

    public function update(Request $request, $id)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesRole());

        if ($validator->fails()) {
            //se retorna la respuesta con los errores
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se busca la existencia del producto
            $role=Role::find($id);
            if (isset($role)) {
                //Se modifican los datos
                $role->name=$request->name;
    
                //Guarda el registro
                $role->save();
    
                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'role_inexistente'],404);
            }
        }
    }

    public function destroy($id)
    {
        //Se busca la existencia del producto
        $role = Role::find($id);
        if (isset($role)) {
            //Si existe lo elimina
            $role->delete();
            //Se retorna una respuesta exitosa
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'role_eliminado'],200);
        }else{
            //Si no existe
            return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'role_inexistente'],404);
        }
    }

    public function rulesRole()
    {
        return [
            'name'=>'required|min:3'
        ];
    }
}
