<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\orderController;

use Laravel\Passport\Passport;

Route::post('/info',function(request $request)
{
    return Auth::user();
});



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
Route::get('/warehouse/all_products',[App\Http\Controllers\ProductController::class,'show_all_products_to_warehouse']);
Route::post('/create_product',[App\Http\Controllers\ProductController::class,'create_products']);
Route::get('/warehouse/searching/{name}',[App\Http\Controllers\ProductController::class,'search_to_product_for_warehouse']);
Route::put('/edit_product/{id}',[App\Http\Controllers\ProductController::class,'edit_product']);
Route::delete('/delete_product/{id}',[App\Http\Controllers\ProductController::class,'delete_product']);

Route::get('/hello',[App\Http\Controllers\ReportController::class,'create_reports']);

});
Route::get('/all_products',[App\Http\Controllers\ProductController::class,'show_all_products']);
Route::get('/pharmacy/searching/{name}',[App\Http\Controllers\ProductController::class,'search_to_product_for_pharmacy']);
Route::get('/show_all_warehouses',[App\Http\Controllers\ReportController::class,'show_all_warehouses']);
//****************



//Routes for orders.
Route::middleware('auth:api')->group( function () {
Route::get('/all_orders_warehouse',[App\Http\Controllers\orderController::class,'show_all_orders_to_warehouse']);
Route::get('/all_orders_pharmacy',[App\Http\Controllers\orderController::class,'show_all_orders_to_pharmacy']);
Route::get('/search_warehouse',[App\Http\Controllers\orderController::class,'search_to_order_for_warehouse']);
Route::get('/search_pharmacy',[App\Http\Controllers\orderController::class,'search_to_order_for_pharmacy']);
Route::post('/create_order',[App\Http\Controllers\orderController::class,'create_order']);
Route::post('/edit_orders_warehouse/{id}',[App\Http\Controllers\orderController::class,'edit_order_warehouse']);
Route::post('/edit_orders_pharmacy/{id}',[App\Http\Controllers\orderController::class,'edit_order_pharmacy']);
Route::delete('/delete_orders_warehouse',[App\Http\Controllers\orderController::class,'delete_order_to_warehouse']);
Route::delete('/delete_orders_pharmacy',[App\Http\Controllers\orderController::class,'delete_order_to_pharmacy']);
});
//************
