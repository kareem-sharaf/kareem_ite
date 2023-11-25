<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WarehouseProductController extends Controller
{

    public function index_warehouse()
{
    $user = auth()->user();
    $id = $user->id;

    $product = Product::where('warehouse_id', $id)->get('name_scientific');
    $message = "this is the all products";

    return response()->json([
        'status' => 1,
        'message' => $message,
        'data' => $product,
    ]);
}





    public function store_warehouse(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        if($user->admin){
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

    //اذا كان المنتج موجود سابقا فقط عدل الكمية

        $existingProduct = Product::where('warehouse_id', $id)
                            ->where('name_scientific', $input['name_scientific'])
                            ->where('name_trade', $input['name_trade'])
                            ->where('type', $input['type'])
                            ->where('company', $input['company'])
                            ->where('ex_date', $input['ex_date'])
                            ->where('price', $input['price'])
                            ->first();

        if ($existingProduct) {
            $existingProduct->quantity += $input['quantity'];
            $existingProduct->save();
            $message = "update product quantity successfully";
            return response()->json([
                'status' => 1,
                'message' => $message,
                'data' => $existingProduct
            ]);
        }
//اذا لم يكن المنتج موجود اضف منتجا جديدا

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

    }else{
        $message="you can't add products ";
        return response()->json(
            [
                'status'=>0,
                'message'=>$message
            ]
        );
    }
}


    public function show_warehouse($name)
{
    $user = auth()->user();
    $id = $user->id;
    $product = Product::where('warehouse_id', $id)
                        ->where('name_scientific', $name)
                        ->orwhere('type', $name)
                        ->get(['name_scientific', 'type']);

    if (is_null($product)) {
        $message = "The product doesn't exist.";
        return response()->json([
            'status' => 0,
            'message' => $message,
        ]);
    }

    $message = "This is the product.";
    return response()->json([
        'status' => 1,
        'message' => $message,
        'data' => $product,
    ]);
}




public function update_warehouse(Request $request,$product_id)
{
        $user = auth()->user();
        $id = $user->id;
        $product = Product::where('warehouse_id', $id)->find($product_id);
    if ($user->id !== $product['warehouse_id']) {
        $message = "You are not authorized to update this product.";
        return response()->json([
            'status' => 0,
            'message' => $message,
        ]);
    }

    $input = $request->all();
    $validator = Validator::make($input, [
        'name_scientific' => 'required',
        'name_trade' => 'required',
        'type' => 'required',
        'company' => 'required',
        'quantity' => 'required',
        'ex_date' => 'required',
        'price' => 'required'
    ]);

    if ($validator->fails()) {
        $message = "There is an error in the inputs.";
        return response()->json([
            'status' => 0,
            'message' => $message,
            'data' => $input,
        ]);
    }

    $product->name_scientific = $input['name_scientific'];
    $product->name_trade = $input['name_trade'];
    $product->type = $input['type'];
    $product->company = $input['company'];
    $product->quantity = $input['quantity'];
    $product->ex_date = $input['ex_date'];
    $product->price = $input['price'];
    $product->save();

    $message = "The product has been updated successfully.";
    return response()->json([
        'status' => 1,
        'message' => $message,
        'data' => $product
    ]);
}



    public function destroy_warehouse($id_product)
    {
        //delete the products which the warehouse want deleted it.
        $user = auth()->user();
        $id = $user->id;
        $product = Product::where('warehouse_id', $id)->find($id_product);
        if (is_null($product)) {
            $message = "The product doesn't exist.";
            return response()->json([
                'status' => 0,
                'message' => $message,
            ]);
        }
        $product->delete();
        $message = "The product deleted successfully.";
         return response()->json([
        'status' => 1,
        'message' => $message,
        'data' => $product,
    ]);

    }




}
