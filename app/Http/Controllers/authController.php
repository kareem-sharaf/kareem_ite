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


    $request->validate([
        'name'=>'required',
        'email'=>'required|min:10|unique:users,email',
        'password'=>'required|min:8'
    ]
    ,['name.required'=>'name is required'],
        ['email.required'=>'email is required',],
        ['email.unique'=>'email already taken'],
       [ 'password.required'=>'password is required']
);











/*
    $validator=validator::make( $request->all(),[
        'name'=>'required',
        'email'=>'required|email',
        'password'=>'required|min:8'
    ]);
    if($validator->fails())
    {
        $message="you must insert all infomration";
        return response()->json(
            [
                'status'=>0,
                'message'=>$message,
            ],500
        );

    }
*/
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $input['admin'] = true;
    $user = User::create($input);
    $success['token'] = $user->createToken('kareem')->accessToken;
    $success['name'] = $user->name;


       $message="Registration completed";
        return response()->json(
            [
                'status'=>1,
                'message'=>$message,
                'data'=>$success,
            ]
        );
   }



   public function login_warehouse(Request $request)
   {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $success['token'] = $user->createToken('kareem')->accessToken;
        $success['name'] = $user->name;
       

        $message="Login completed";
        return response()->json(
            [
                'status'=>1,
                'message'=>$message,
                'data'=>$success,
            ]);
    }

   else{
    $message="wrong email or password ";
    return response()->json(
        [
            'status'=>0,
            'message'=>$message,
            'data'=>[],
        ]
        ,500 );
    }
   }








    //functions for pharmacy

   public function register_pharmacy(Request $request)
   {

   $request->validate([
        'name'=>'required',
        'number'=>'required|min:10|unique:users,number',
        'password'=>'required|min:8'
    ]
    ,['name.required'=>'name is required'],
        ['number.required'=>'mobile number is required',],
        ['number.unique'=>'mobile number already taken'],
       [ 'password.required'=>'password is required']
);

   /* if($validator->fails())
    {
        if('number.unique'==='mobile number already taken')
        $message="mobile number already taken";
    else
    $message="you must insert all infomration";
        return response()->json(
            [
                'status'=>0,
                'message'=>$message,
            ],500
        );

    }*/
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $input['admin'] = false;
    $user = User::create($input);
    $success['token'] = $user->createToken('kareem')->accessToken;
    $success['name'] = $user->name;

    $message="Registration completed";
        return response()->json(
            [
                'status'=>1,
                'message'=>$message,
                'data'=>$success,
            ]
        );
   }



   public function login_pharmacy(Request $request)
   {



    $request->validate([
        'number'=>'required|min:10',
        'password'=>'required|min:8'
    ]
   ,
        ['number.required'=>'mobile number is required',],
       [ 'password.required'=>'password is required']
);







/*

    $validator=validator::make( $request->all(),[
        'name'=>'required',
        'number'=>'required|min:10|exists:users,number',
        'password'=>'required|min:8'
    ]);

    if($validator->fails())
    {
        $message="you must insert all infomration";
        return response()->json(
            [
                'status'=>0,
                'message'=>$message,
            ]
            ,500 );
    }
*/
    if (Auth::attempt(['number' => $request->number, 'password' => $request->password])) {
        $user = Auth::user();
        $success['token'] = $user->createToken('kareem')->accessToken;
        $success['name'] = $user->name;
       
        $message="Login completed";
        return response()->json(
            [
                'status'=>1,
                'message'=>$message,
                'data'=>$success,
                
            ]);
    }

   else{
    $message="wrong email or password ";
    return response()->json(
        [
            'status'=>0,
            'message'=>$message,
            'data'=>[],
        ]
    );
    }
   }

   public function logout(Request $request)
   {

$token= Auth::user()->token();
$token->revoke();
    

    return response()->json(
        [
            'status'=>1,
            'message'=>'logout succssuflly',
            'data'=>[],
          
        ]
    );

}
}
