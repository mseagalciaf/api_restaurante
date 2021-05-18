<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware(['auth:sanctum','role:SuperAdmin'])->only(['store','update','destroy']);
    }

    public function index()
    {
        $products= Product::select('products.*','categories.name as category_name')->leftjoin('categories','products.category_id','=','categories.id')->get();
        foreach ($products as $key => $value) {
            $value->groups=$value->groups;
        }
        return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$products],200);
    }

    public function store(Request $request)
    {   
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesProduct());

        if ($validator->fails()) {
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se almacenan los datos
            $product = new Product($request->all());
            if ($request->image) {
                $path = $this->base64_to_jpeg($request->image,$request->name);
                $product->image=$path;
            }
            $product->save();

            $product->groups()->attach($request->groups);
            //retorna la respuesta
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'productos_agregados'],200);
        }
    }

    public function show($id)
    {
        $product= Product::select('products.*','categories.name as category_name')
                                ->leftjoin('categories','products.category_id','=','categories.id')
                                ->where('products.id', $id)
                                ->first();
        $product->groups=$product->groups;

        foreach ($product->groups as $key => $value) {
            $value->modifiers=$value->modifiers ;
        }
        
        if(isset($product)){
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>$product],200);
        }else{
            return response()->json(['status'=>false,'codigo_http'=>404,'data'=>'producto_inexistente'],404);
        }
    }

    public function update(Request $request, $id)
    {
        //Se ejecuta la validacion con las reglas de producto
        $validator = Validator::make($request->all(),$this->rulesProduct());

        if ($validator->fails()) {
            //se retorna la respuesta con los errores
            return response()->json(['status'=>false,'codigo_http'=>400,'data'=>$validator->errors()],400);
        }else{
            //Si pasa la validacion
            //Se busca la existencia del producto
            $product=Product::find($id);

            if (isset($product)) {
                //Se modifican los datos
                $product->name=$request->name;
                $product->price=$request->price;
                $product->category_id=$request->category_id;
                $product->groups()->sync($request->groups);
    
                if ($request->image && $request->image!=$product->image) {
                    $this->deleteCurrentImage($product->image);
                    $path = $this->base64_to_jpeg($request->image,$request->name);
                    $product->image= $path;
                }

                //Guarda el registro
                $product->save();
                


                //Retorna una respuesta exitosa
                return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'cambios_realizados'],200);  
            }else{
                //Si no existe
                return response()->json(['status'=>true,'codigo_http'=>404,'data'=>'producto_inexistente'],404);
            }
        }
    }
    
    public function destroy($id)
    {
        //Se busca la existencia del producto
        $product = Product::find($id);
        if (isset($product)) {
            //Si existe lo elimina
            $this->deleteCurrentImage($product->image);
            $product->delete();
            //Se retorna una respuesta exitosa
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_eliminado'],200);
        }else{
            //Si no existe
            return response()->json(['status'=>true,'codigo_http'=>200,'data'=>'producto_inexistente'],200);
        }
        
    }

    public function rulesProduct()
    {
        return [
            'name'=>'required|min:3',
            'price'=>'required|integer|min:1',
            'category_id'=>'required|exists:categories,id',
            'groups' => 'required|array',
            'groups.*' => 'required|distinct|integer|exists:groups,id'
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
        
        $path = 'products/'.time().'_'.$name.'.'.$format[1];
        Storage::disk('public')->put($path,base64_decode($data[1]));
        return 'storage/'.$path;

    }
}
