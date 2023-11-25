<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\WarehouseProductController;
use App\Http\Controllers\PharmacyProductController;
use App\Http\Controllers\PharmacyWarehouseController;

use Laravel\Passport\Passport;

Route::post('/info',function(request $request)
{
    return Auth::user();
});

Route::middleware('auth:api')->group( function () {
   Route::get('/logout',[App\Http\Controllers\authController::class,'logout']);
   Route::get('/pharmacy/all_orders_in_pharmacy',[App\Http\Controllers\orderController::class,'all_orders_in_pharmacy']);
   Route::post('/pharmacy/create_order',[App\Http\Controllers\orderController::class,'create_order']);
});

//Routes for Auth.
Route::post('/warehouse/register',[App\Http\Controllers\authController::class,'register_warehouse']);
Route::post('/warehouse/login',[App\Http\Controllers\authController::class,'login_warehouse']);
Route::post('/pharmacy/register',[App\Http\Controllers\authController::class,'register_pharmacy']);
Route::post('/pharmacy/login',[App\Http\Controllers\authController::class,'login_pharmacy']);
Route::post('/warehouse/forget',[App\Http\Controllers\authController::class,'warehouse_forget']);
Route::post('/pharmacy/forget',[App\Http\Controllers\authController::class,'pharmacy_forget']);

Route::middleware('auth:api')->group( function () {
Route::post('/warehouse/resetpassword',[App\Http\Controllers\authController::class,'warehouse_reset_password']);
Route::post('/pharmacy/resetpassword',[App\Http\Controllers\authController::class,'pharmacy_reset_password']);
Route::post('/warehouse/edit_information',[App\Http\Controllers\authController::class,'warehouse_edit_info']);
Route::post('/pharmacy/edit_information',[App\Http\Controllers\authController::class,'pharmacy_edit_info']);
Route::delete('/warehouse/delete_user',[App\Http\Controllers\authController::class,'warehouse_delete']);
Route::delete('/pharmacy/delete_user',[App\Http\Controllers\authController::class,'pharmacy_delete']);
});


Route::middleware('auth:api')->group( function () {


Route::post('/pharmacy/edit_order_for_pharmacy',[App\Http\Controllers\orderController::class,'edit_order_for_pharmacy']);

Route::get('/pharmacy/order_info_for_pharmacy',[App\Http\Controllers\orderController::class,'order_info_for_pharmacy']);

Route::post('/pharmacy/delete_order_pharmacy',[App\Http\Controllers\orderController::class,'delete_order_pharmacy']);

Route::get('/pharmacy/all_orders_in_pharmacy',[App\Http\Controllers\orderController::class,'all_orders_in_pharmacy']);


Route::get('/pharmacy/all_orders_in_pharmacy',[App\Http\Controllers\orderController::class,'all_orders_in_pharmacy']);

Route::post('/pharmacy/create_order',[App\Http\Controllers\orderController::class,'create_order']);

//Routes for products_warehouse
Route::get('/warehouse/index',[App\Http\Controllers\WarehouseProductController::class,'index_warehouse']);
Route::post('/warehouse/store',[App\Http\Controllers\WarehouseProductController::class,'store_warehouse']);
Route::get('/warehouse/show/{name}',[App\Http\Controllers\WarehouseProductController::class,'show_warehouse']);
Route::put('/warehouse/update/{id}',[App\Http\Controllers\WarehouseProductController::class,'update_warehouse']);
Route::delete('/warehouse/destroy/{id}',[App\Http\Controllers\WarehouseProductController::class,'destroy_warehouse']);
//****************
Route::get('/warehouse/all_orders_in_warehouse',[App\Http\Controllers\orderController::class,'all_orders_in_warehouse']);
Route::post('/warehouse/store_warehouse',[App\Http\Controllers\productController::class,'store_warehouse']);
Route::post('/warehouse/edit_status',[App\Http\Controllers\orderController::class,'edit_status']);
});

//Routes for products_pharmacy
Route::get('/pharmacy/index',[App\Http\Controllers\PharmacyProductController::class,'index_pharmacy']);
Route::get('/pharmacy/index/{id}',[App\Http\Controllers\PharmacyProductController::class,'special_index_pharmacy']);
Route::get('/pharmacy/show/{name}',[App\Http\Controllers\PharmacyProductController::class,'show_pharmacy']);
//Routes for warehouser_pharmacy
Route::get('/all_warehouses',[App\Http\Controllers\PharmacyWarehouseController::class,'index']);
