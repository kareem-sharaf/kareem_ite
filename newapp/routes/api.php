<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\ProductController;

use Laravel\Passport\Passport;

Route::post('/info',function(request $request)
{
    return Auth::user();
});





//Routes for order.
Route::get('/warehouse/all_orders_in_warehouse',[App\Http\Controllers\orderController::class,'all_orders_in_warehouse']);
Route::post('/warehouse/store_warehouse',[App\Http\Controllers\productController::class,'store_warehouse']);
Route::post('/warehouse/edit_status',[App\Http\Controllers\orderController::class,'edit_status']);
Route::middleware('auth:api')->group( function () {
Route::get('/pharmacy/all_orders_in_pharmacy',[App\Http\Controllers\orderController::class,'all_orders_in_pharmacy']);
Route::post('/pharmacy/create_order',[App\Http\Controllers\orderController::class,'create_order']);
});
//*********











//Routes for Auth.
Route::post('/warehouse/register',[App\Http\Controllers\authController::class,'register_warehouse']);
Route::post('/warehouse/login',[App\Http\Controllers\authController::class,'login_warehouse']);
Route::post('/pharmacy/register',[App\Http\Controllers\authController::class,'register_pharmacy']);
Route::post('/pharmacy/login',[App\Http\Controllers\authController::class,'login_pharmacy']);
Route::post('/warehouse/forget',[App\Http\Controllers\authController::class,'warehouse_forget']);
Route::post('/pharmacy/forget',[App\Http\Controllers\authController::class,'pharmacy_forget']);

Route::middleware('auth:api')->group( function () {
Route::get('/logout',[App\Http\Controllers\authController::class,'logout']);
Route::post('/reset_password',[App\Http\Controllers\authController::class,'reset_password']);
Route::post('/edit_information',[App\Http\Controllers\authController::class,'edit_info']);
Route::delete('/delete_user',[App\Http\Controllers\authController::class,'delete_the_user']);
});
//*********








//Routes for products.
Route::middleware('auth:api')->group( function () {
Route::get('/warehouse_products',[App\Http\Controllers\ProductController::class,'show_all_products_to_warehouse']);
Route::post('/warehouse/create_products',[App\Http\Controllers\ProductController::class,'create_products']);
Route::get('/warehouse/searching_product/{name}',[App\Http\Controllers\ProductController::class,'search_to_product_for_warehouse']);
Route::put('/edit_product/{id}',[App\Http\Controllers\ProductController::class,'edit_product']);
Route::delete('/warehouse/destroy/{id}',[App\Http\Controllers\ProductController::class,'delete_product']);
});
Route::get('/show_all_products',[App\Http\Controllers\ProductController::class,'show_all_products']);
Route::get('/pharmacy/searching_product/{name}',[App\Http\Controllers\ProductController::class,'search_to_product_for_pharmacy']);
Route::get('/all_warehouses',[App\Http\Controllers\ProductController::class,'show_all_warehouses']);
Route::get('/show_one_warehouse/{id}',[App\Http\Controllers\ProductController::class,'show_one_warehouse']);
//*************


