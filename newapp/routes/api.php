<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use Laravel\Passport\Passport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/info',function(request $request)
{
    return Auth::user();
});






Route::middleware('auth:api')->group( function () {
   Route::get('/logout',[App\Http\Controllers\authController::class,'logout']);
});

//routes for warehouse
Route::post('/warehouse/register',[App\Http\Controllers\authController::class,'register_warehouse']);
Route::post('/warehouse/login',[App\Http\Controllers\authController::class,'login_warehouse']);


Route::middleware('auth:api')->group( function () {

Route::get('/warehouse/all_orders_in_warehouse',[App\Http\Controllers\orderController::class,'all_orders_in_warehouse']);
 Route::post('/warehouse/store_warehouse',[App\Http\Controllers\productController::class,'store_warehouse']);

 Route::post('/warehouse/edit_status',[App\Http\Controllers\orderController::class,'edit_status']);

});

//routes for pharmacy
Route::post('/pharmacy/register',[App\Http\Controllers\authController::class,'register_pharmacy']);
Route::post('/pharmacy/login',[App\Http\Controllers\authController::class,'login_pharmacy']);
Route::middleware('auth:api')->group( function () {

    Route::get('/pharmacy/all_orders_in_pharmacy',[App\Http\Controllers\orderController::class,'all_orders_in_pharmacy']);
   
Route::post('/pharmacy/create_order',[App\Http\Controllers\orderController::class,'create_order']);
});



