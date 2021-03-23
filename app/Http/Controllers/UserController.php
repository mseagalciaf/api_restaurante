<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $user=User::create($request->all());
        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'usuarios_agregados'],200);
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function update(Request $request, User $user)
    {
        $user->nombre=$request->nombre;
        $user->correo=$request->correo;
        $user->password=$request->password;
        $user->role_id=$request->role_id;
        $user->sucursale_id=$request->sucursale_id;
        $user->save();

        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);

    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'usuario_eliminado'],200);
    }
}
