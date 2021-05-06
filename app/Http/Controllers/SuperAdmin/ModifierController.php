<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Modifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModifierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum','role:SuperAdmin'])->only(['store','update','delete']);
    }

    public function index()
    {
        $modifiers = Modifier::all();
        return response()->json([
            'status' => true,
            'codigo_http' => 200,
            'data' => $modifiers
        ],200);
    }

    public function store(Request $request)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesModifiers());

        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            Modifier::create($request->all());

            return response()->json(['status' => true,'codigo_http' => 200, 'data' => 'Modificador_Agregado'],200);
        }
    }

    public function show($id)
    {
        $modifier = Modifier::find($id);
        if (isset($modifier)) {
            return response()->json(['status' => true, 'codigo_http' => 200, 'data' => $modifier],200);
        }else{
            return response()->json(['status' => false, 'codigo_http' => 404, 'data' => 'modificador_inexistente'],404);
        }
    }

    public function update(Request $request, $id)
    {
        $modifier = Modifier::find($id);
        if (isset($modifier)) {
            $validator = Validator::make($request->all(),$this->rulesModifiers());
            if ($validator->fails()) {
                return response()->json(['status' => false, 'codigo_http' => 400, 'data' => $validator->errors()],400);
            }else{
                $modifier->name = $request->name;
                $modifier->save();
                return response()->json(['status' => true, 'codigo_http' => 200, 'data' => 'cambios_realizados'],200);
            }
        }
    }

    public function destroy($id)
    {
        $modifier = Modifier::find($id);
        if (isset($modifier)) {
            $modifier->delete();
            return response()->json(['status' => true, 'codigo_http' => 200, 'dtata' => 'modificador_eliminado'],200);
        }else{
            return response()->json(['status' => false, 'codigo_http' => 404, 'data' => 'modificador_inexistente'],404);
        }
    }

    public function rulesModifiers()
    {
        return [
            'name'=>'required|min:3'
        ];
    }
}
