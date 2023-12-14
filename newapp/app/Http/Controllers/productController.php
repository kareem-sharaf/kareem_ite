<?php

namespace App\Http\Controllers;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
class ProductController extends Controller
{

    public function show_all_products_to_warehouse()
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



        public function show_all_products()
    {
        $product = Product::get('name_scientific');
        $message = "this is the all products";

        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $product,
        ]);
    }


//REPLACE ID WITH NAME OR EDIT THE DATA IN MODEL AFTER UPDATING THE CODE
    public function create_products(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        if($user->admin){
        $input = $request->all();
      //  try {
        $request->validate([
            'name_scientific'=>'required',
            'name_trade'=>'required',
            'type'=>'required',
            'company'=>'required',
            'quantity'=>'required|integer|min:1',
            'ex_date'=>'required|date|dateformat:Y/m/d',
            'price'=>'required'
        ],
        [
            'name_scientific.required' => 'name scientific is required',
            'name_trade.required'=> 'name trade is required',
            'type.required'=> 'type is required',
            'company.required'=> 'company is required',
            'quantity.required'=> 'quantity is required',
            'quantity.min'=> 'quantity must be 1 at least',
            'ex_date.required'=> 'ex_date is required',
            'ex_date.date'=> 'ex_date must be like that 0000/00/00',
            'ex_date.dateformat' => 'ex_date must be like that 0000/00/00',
            'price.required'=> 'price is required',
        ]);


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
        'status' => true,
        'message' => $message,
        'data' => $existingProduct
        ]);
        }
        //اذا لم يكن المنتج موجود اضف منتجا جديدا


        $user = Auth::user();
        $input['warehouse_id'] = $user->id;
        $warehouse_name=User::where('id',$user->id)->get('name')->first();
        $input['warehouse_name'] =  $warehouse_name->name;


        $product = Product::create($input);
        $message="add product successfully";



        return response()->json(
        [
        'status'=>true,
        'message'=>$message,
        'data'=>$product
        ]
        );
            }
      /*  } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred'
            ]);
        }*/





    else{
        $message="you can't add products ";
        return response()->json(
            [
                'status'=>false,
                'message'=>$message
            ]
        );
    }
}


    public function search_to_product_for_warehouse($name)
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

public function search_to_product_for_pharmacy($name)
{
    $product = Product::where('name_scientific', $name)
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

//all warehouses
public function show_all_warehouses()
{
        $warehouse = User::where('admin', true)->get('name');
        $message = "this is the all warehouses";

        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $warehouse,
        ]);
    }


//all prod in my warehouse
    public function show_one_warehouse(request $request)
    {

        $product = Product::where('warehouse_id',$request->id)->get('name_scientific');
        $message = "this is the all products";
        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $product,
        ]);
    }




    public function edit_product(Request $request,$product_id)
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
        'quantity' => 'required|integer|min:1',
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



    public function delete_product($id_product)
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
//REPLACE ID WITH NAME
//MAKE IT MORE CLEAN
public function add_or_delete_from_favorites(request $request)
{
    $pharmacy_id=auth()->id();
    $warehouse_id=Product::where('id',$request->id)->get('warehouse_id')->first();
    $warehouse_id=$warehouse_id->warehouse_id;

$favorite=Favorite::where('product_id',$request->id)
->where('pharmacy_id',$pharmacy_id)
->where('warehouse_id', $warehouse_id)
->get()->first();

$data=Product::where('id',$request->id)->get('name_scientific')->first();
if($favorite==null)
{
     $product_name=Product::where('id',$request->id)->get('name_scientific')->first();

    $pharmacy_name=User::where('id',$pharmacy_id)->get('name')->first();

    $warehouse_name=User::where('id',$warehouse_id)->get('name')->first();

    Favorite::create([
        'product_id'=> $request->id,
        'product_name'=>$product_name->name_scientific ,

        'pharmacy_id'=> $pharmacy_id,
        'pharmacy_name'=> $pharmacy_name->name,

        'warehouse_id'=> $warehouse_id,
        'warehouse_name'=> $warehouse_name->name,

    ]);

return response()->json([
    'status'=>1,
    'message'=>'product added to favorite list succsussfully',
    'data'=>$data
]);
}
else
{

  $favorite=Favorite::where('product_id',$request->id)->where('pharmacy_id',$pharmacy_id)->where('warehouse_id', $warehouse_id);

    $favorite->delete();

return response()->json([
    'status'=>1,
    'message'=>'product deleted from favorite list succsussfully',
    'data'=>$data
]);
}
}


public function show_my_favorites()
{


    $pharmacy_id=auth()->id();

// $favorite=Favorite::where('pharmacy_id', $pharmacy_id)->get('pharmacy_name')->first();
// dd($favorite);
    $favorite=Favorite::where('pharmacy_id', $pharmacy_id)->get()->first();

    if($favorite==null)
    {
        return response()->json([
            'status'=>0,
            'message'=>'there is no items in favortie list',
            'data'=>[]
        ]);
    }
    else
    {
        return response()->json([
            'status'=>1,
            'message'=>'all favorite items returned succsussfully',
            'data'=>$favorite
        ]);
    }

}



}
