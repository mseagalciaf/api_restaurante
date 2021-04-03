<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesUser());
        
        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            $user =User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password= Hash::make($request->password),
                'role_id' => $request->role_id,
                'sucursale_id' => $request->sucursale_id
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => false,
                'data' => 'invalid_credentials'
            ],401);
        }
        $user = User::where('email',$request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
    }

    public function userinfo(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {   
        $user=User::find($request->id);
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'data' => 'success_logout'
            ]);            
        }

        return response()->json([
            'status' => false,
            'data' => 'wrong_logout'
        ]);  

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
}
