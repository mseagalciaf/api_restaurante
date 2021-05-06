<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\CityController;
use App\Http\Controllers\SuperAdmin\GroupController;
use App\Http\Controllers\SuperAdmin\ModifierController;
use App\Http\Controllers\SuperAdmin\ProductController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\SucursalController;
use App\Http\Controllers\SuperAdmin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




//------------------- Authentication ----------------------------
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout', [AuthController::class,'logout']);
Route::post('userinfo',[AuthController::class,'userinfo'])->middleware(['auth:sanctum']);

//----------------- SuperAdmin Endpoints ------------------------------
Route::resource('users', UserController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('products', ProductController::class, ['except'=> ['create','edit']]);
Route::resource('categories', CategoryController::class, ['except'=> ['create','edit']]);
Route::resource('cities', CityController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('sucursales', SucursalController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('groups', GroupController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('roles', RoleController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('modifiers', ModifierController::class, ['except' => ['create','edit']]);

//-------------------Admin Endpoints----------------------------


//--------------------User Endpoints ----------------------------


//--------------------General Endpoints---------------------------
Route::resource('sales', SucursalController::class, ['except'=> ['create','edit']]);


//-----------------Prueba-----------------------------------------