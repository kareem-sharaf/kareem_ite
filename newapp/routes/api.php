<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//routes for warehouse
Route::post('/warehouse/register',[App\Http\Controllers\authController::class,'register_warehouse']);
Route::post('/warehouse/login',[App\Http\Controllers\authController::class,'login_warehouse']);
Route::post('/logout',[App\Http\Controllers\authController::class,'logout']);

//routes for pharmacy
Route::post('/pharmacy/register',[App\Http\Controllers\authController::class,'register_pharmacy']);
Route::post('/pharmacy/login',[App\Http\Controllers\authController::class,'login_pharmacy']);
Route::post('/logout',[App\Http\Controllers\authController::class,'logout']);
