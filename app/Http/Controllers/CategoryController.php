<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:sanctum','role:SuperAdmin'])->only(['store','update','destroy']);
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
            $category= new Category($request->all());
            
            if ($request->image) {
                $path = $this->base64_to_jpeg($request->image,$request->name);
            }
            //Renombrar el archivo
            //$path = $request->image->storeAs('public/categories','id'.'_'.$request->name .'_'.$request->image->extension());
            
            $category->image=$path;
            $category->save();

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

                if ($request->image && $request->image!=$category->image) {
                    $this->deleteCurrentImage($category->image);
                    $path = $this->base64_to_jpeg($request->image,$request->name);
                    $category->image= $path;
                }

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
            $this->deleteCurrentImage($category->image);
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
            'name'=>'required|min:3',
            
        ];
    }

    public function deleteCurrentImage($ruta){
        $path = str_replace('storage','public',$ruta);
        Storage::delete([$path]);
    }

    public function base64_to_jpeg($base64_string,$name)
    {
        $data = explode( ',', $base64_string );

        $format = explode(';',$data[0]);
        $format = explode('/',$format[0]);
        $name = str_replace(' ','_',$name);
        
        $path = 'categories/'.time().'_'.$name.'.'.$format[1];
        Storage::disk('public')->put($path,base64_decode($data[1]));
        return 'storage/'.$path;

    }
}
