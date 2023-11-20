<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;
use Hash;
class authController extends BaseController
{


    //functions for warehouse

   public function register_warehouse(Request $request)
   {

    $validator=validator::make( $request->all(),[
        'name'=>'required',
        'email'=>'required|email',
        'password'=>'required|min:8'
    ]);
    if($validator->fails())
    {
        return 'error';

    }
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $input['admin'] = true;
    $user = User::create($input);
    $success['token'] = $user->createToken('kareem')->accessToken;
    $success['name'] = $user->name;
    return 'success';
   }



   public function login_warehouse(Request $request)
   {
    if (Auth::attempt(['name' => $request->name,'email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $success['token'] = $user->createToken('kareem')->accessToken;
        $success['name'] = $user->name;
        return "success";
    }

   else{
     return "error";
    }
   }








    //functions for pharmacy

   public function register_pharmacy(Request $request)
   {

    $validator=validator::make( $request->all(),[
        'name'=>'required',
        'number'=>'required|min:10',
        'password'=>'required|min:8'
    ]);
    if($validator->fails())
    {
        return "error";

    }
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $input['admin'] = false;
    $user = User::create($input);
    $success['token'] = $user->createToken('kareem')->accessToken;
    $success['name'] = $user->name;
    return "success";
   }



   public function login_pharmacy(Request $request)
   {
    if (Auth::attempt(['name' => $request->name,'number' => $request->number, 'password' => $request->password])) {
        $user = Auth::user();
        $success['token'] = $user->createToken('kareem')->accessToken;
        $success['name'] = $user->name;
        return "success";
    }

   else{
        return "error";
    }
   }














   public function logout()
   {
    Session::flush();
    Auth::logout();
    if(Auth::logout())
    {
    return 'success';
}
else
{
    return 'error';
}
   }
}
