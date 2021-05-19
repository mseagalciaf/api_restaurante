<?php

use App\Http\Controllers\admin\ProductAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ModifierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Visualizaciones no son restringidas 
// Modificaciones son restringidas

//------------------- Authentication ----------------------------
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout', [AuthController::class,'logout']);
Route::post('userinfo',[AuthController::class,'userinfo'])->middleware(['auth:sanctum']);

//----------------- General Resources ------------------------------
Route::resource('users', UserController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('products', ProductController::class, ['except'=> ['create','edit']]);
Route::resource('categories', CategoryController::class, ['except'=> ['create','edit']]);
Route::resource('cities', CityController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('sucursales', SucursalController::class, ['except'=> ['create','edit']]);
Route::resource('groups', GroupController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('roles', RoleController::class, ['except'=> ['create','edit']])->middleware(['auth:sanctum','role:SuperAdmin']);
Route::resource('modifiers', ModifierController::class, ['except' => ['create','edit']]);
Route::resource('sales', SaleController::class, ['except' => ['create','edit']]);

//-------------------------Admin Products-----------------------
// Los administradores solo podran visualizar los productos de su sucrsal.
// Activar o Desactivar el producto para su sucursal
Route::get('sucursales/{sucursale}/products/{productId}',[ProductAdminController::class,'sucursalProduct']);
Route::put('sucursales/{sucursale}/products/{productId}',[ProductAdminController::class,'sucursalProductUpdate']);
Route::get('sucursales/{sucursale}/products',[ProductAdminController::class,'sucursalProducts']);
