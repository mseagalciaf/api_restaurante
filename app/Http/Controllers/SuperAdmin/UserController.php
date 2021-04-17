<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        
        foreach ($users as $key => $value) {
            $value->roles=$this->getRoles($value->id);
        }
        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$users],200);
    }

    public function store(Request $request)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesUser());
        
        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password= Hash::make($request->password),
                'sucursale_id' => $request->sucursale_id,
            ]);
            $user->assignRole($request->role_id);   

            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'usuario_agregados'],200);
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        $user->roles=$user->getRoleNames();
        if(isset($user)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$user],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>200,'data'=>'usuario_inexistente'],200);
        }
    }

    public function update(Request $request, $id)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesUserUpdate());

        if ($validator->fails()) {
            //se retorna la respuesta con los errores
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se busca la existencia del producto
            $user=User::find($id);
            if (isset($user)) {
                //Se modifican los datos
                $user->name=$request->name;
                $user->email=$request->email;
                if (!$request->password==="") {
                    $user->password=Hash::make($request->password);
                }
                $user->syncRoles([$request->role_id]);
                $user->sucursale_id=$request->sucursale_id;
    
                //Guarda el registro
                $user->save();
    
                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'usuario_inexistente'],200);
            }
        }
    }

    public function destroy($id)
    {
        //Se busca la existencia del producto
        $user = User::find($id);
        if (isset($id)) {
            //Si existe lo elimina
            $user->delete();
            //Se retorna una respuesta exitosa
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'usuario_eliminado'],200);
        }else{
            //Si no existe
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'usuario_inexistente'],200);
        }
    }

    public function rulesUser()
    {
        return [
            'name'=>'required|min:3',
            'email'=>'required|email:rfc,dns',
            'password'=>'required|min:1',
            'role_id' => 'required|exists:roles,id',
            'sucursale_id' => 'required|exists:sucursales,id'
        ];
    }

    public function rulesUserUpdate()
    {
        return [
            'name'=>'required|min:3',
            'email'=>'required|email:rfc,dns',
            'role_id' => 'required|exists:roles,id',
            'sucursale_id' => 'required|exists:sucursales,id'
        ];
    }

    public function getRoles($id )
    {
        $user = User::find($id);
        return $user->getRoleNames();
    }

    public function getPermissions($id)
    {
        $user = User::find($id);
        return $user->getAllPermissions();
    }
}
