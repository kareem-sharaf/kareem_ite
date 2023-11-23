<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Order;
use App\Models\Product;
class productController extends Controller
{
    
    public function store_warehouse(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'name_scientific'=>'required',
            'name_trade'=>'required',
            'type'=>'required',
            'company'=>'required',
            'quantity'=>'required',
            'ex_date'=>'required',
            'price'=>'required'
        ]);
        if ($validator->fails()) {
            $message="there is wrong in inputs.";
            return response()->json(
                [
                    'status'=>0,
                    'message'=>$message,
                    'data'=>$input,
                ]
            );
        }

        $user = Auth::user();
        $input['warehouse_id'] = $user->id;
        $product = Product::create($input);
        $message="add product successfully";
        return response()->json(
            [
                'status'=>1,
                'message'=>$message,
                'data'=>$product
            ]
        );

    }
}
