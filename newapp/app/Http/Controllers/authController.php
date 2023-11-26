<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProductWarehouseController;

use Validator;
use Hash;
class authController extends Controller
{


    //functions for warehouse

   public function register_warehouse(Request $request)
   {
    $request->validate([
        'name'=>'required',
        'email'=>'required|min:10|unique:users,email',
        'password'=>'required|min:8',
        'number'=>'required|min:10|unique:users,number',
    ]
    ,['name.required'=>'name is required'],
        ['email.required'=>'email is required'],
        ['email.unique'=>'email already taken'],
       [ 'password.required'=>'password is required'],
       ['number.required'=>'number is required'],
       ['number.unique'=>'number already taken'],
);
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



   public function register_pharmacy(Request $request)
   {

   $request->validate([
        'name'=>'required',
        'number'=>'required|min:10|unique:users,number',
        'password'=>'required|min:8',
        'email'=>'required|min:10|unique:users,email',
    ]
    ,['name.required'=>'name is required'],
        ['number.required'=>'mobile number is required'],
        ['number.unique'=>'mobile number already taken'],
        [ 'password.required'=>'password is required'],
        ['email.required'=>'email is required'],
        ['email.unique'=>'email already taken'],
   );
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
         'message'=>'logout success',
         'data'=>[],

     ]
 );

}



   public function warehouse_forget(Request $request)
{
    $user = User::where('email', $request->input('email'))
                ->where('number', $request->input('number'))
                ->first();

    if($user){
        $token = $user->createToken('kareem')->accessToken;
        $message = "check the user";
        return response()->json([
            'status' => 1,
            'message' => $message,
            'token' => $token,
        ]);
    } else {
        $message = "wrong inputs";
        return response()->json([
            'status' => 0,
            'message' => $message,
            'token' => null,
        ]);
    }
}





public function pharmacy_forget(Request $request)
{
    $user = User::where('email', $request->input('email'))
    ->where('number', $request->input('number'))
    ->first();

    if($user){
        $token = $user->createToken('kareem')->accessToken;
        $message = "check the user";
        return response()->json([
            'status' => 1,
            'message' => $message,
            'token' => $token,
        ]);
    } else {
        $message = "wrong inputs";
        return response()->json([
            'status' => 0,
            'message' => $message,
            'token' => null,
        ]);
    }
}



public function reset_password(Request $request)
{
    $user = auth()->user();

    $newPassword = $request->input('new_password');
    $user->password = bcrypt($newPassword);
    $user->save();

    $token = $user->createToken('kareem')->accessToken;
        $message = "Login completed";
        return response()->json([
            'status' => 1,
            'message' => $message,
            'token' => $token,
        ]);
    }



    public function edit_info(Request $request){
        $user = auth()->user();

        if($request->has('name')){
            $user->name = $request->input('name');
        }

        if($request->has('password')){
            $user->password = bcrypt($request->input('password'));
        }

        if($request->has('number')){
            $user->number = $request->input('number');
        }

        $user->save();

        $message = "the information updated successfully";
        return response()->json([
            'status' => 1,
            'message' => $message,
        ]);
    }





    public function delete_the_user(Request $request){
        $user = auth()->user();
        $user->delete();
        $message = "The user deleted successfully.";
         return response()->json([
        'status' => 1,
        'message' => $message,
        'data' => $user,
    ]);

    }

 }
