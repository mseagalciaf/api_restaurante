<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    
    public function __construct(){
        $this->middleware(['auth:sanctum','role:superAdmin'])->only(['store','update','destroy']);
    }

    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'status' => true,
            'codigo_http' => 200,
            'data' => $categories
        ],200);
    }

    public function store(Request $request)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesCategory());

        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            Category::create($request->all());

            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'categorias_agregadas'],200);
        }
    }

    public function show($id)
    {
        $category = Category::find($id);
        if(isset($category)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$category],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'categoria_inexistente'],404);
        }
    }

    public function update(Request $request, $id)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesCategory());

        if ($validator->fails()) {
            //se retorna la respuesta con los errores
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se busca la existencia del producto
            $category=Category::find($id);
            if (isset($category)) {
                //Se modifican los datos
                $category->name=$request->name;
    
                //Guarda el registro
                $category->save();
    
                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'category_inexistente'],404);
            }
        }
    }


    public function destroy($id)
    {
        //Se busca la existencia del producto
        $category = Category::find($id);
        if (isset($category)) {
            //Si existe lo elimina
            $category->delete();
            //Se retorna una respuesta exitosa
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'categoria_eliminada'],200);
        }else{
            //Si no existe
            return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'categoria_inexistente'],404);
        }
    }

    public function rulesCategory()
    {
        return [
            'name'=>'required|min:3'
        ];
    }
}
