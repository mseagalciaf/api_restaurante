<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
//------------------- Authentication ----------------------------
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout', [AuthController::class,'logout']);
//-----------------  Endpoints SuperAdmin------------------------------
Route::resource('users', UserController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('products', ProductController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);

//-------------------Endpoints Admin----------------------------


//--------------------Endpoints User----------------------------

//-----------------Prueba-----------------------------------------
Route::post('userinfo',[AuthController::class,'userinfo'])->middleware(['auth:sanctum','permission:admin.users.index']);