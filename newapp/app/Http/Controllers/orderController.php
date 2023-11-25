<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class orderController extends Controller
{

  // DONT FORGET TO SEND THE WAREOSUE_ID !!!!!


  // in the json file send the id and name and quantity
  public function create_order(request $request)
  {
   $request->validate([

    'content'=>'required'
   ]
   ,['content.required'=>'there is no contnet in the order']);

  Order::create([
    'user_id'=>auth()->id(),
    'status'=>'pending',
    'pay_status'=>'pending',
    //or take the warehouse_id from the contnet
    'warehouse_id'=>$request->warehouse_id,
    'content'=> json_encode($request->content)
  ]);
  return response()->json(
    [
      'status'=>1,
        'message'=>'orders created successfully',
        'data'=>$request->content
    ]
    );

  }

  public function accept_ignore_order(request $request)
  {
   
  }
  
  public function all_orders_in_warehouse()
  {
    $warehouse_id=auth()->id();
    $orders=Order::where('warehouse_id',$warehouse_id)->get();
    if($orders==null)
    {
      return response()->json(
        [
          'status'=>0,
            'message'=>'there is no orders in the warehouse',
            'data'=>$orders
        ]
        );
    }
    return response()->json(
        [
          'status'=>1,
            'message'=>'orders returned successfully',
            'data'=>$orders
        ]
        );
  }


  public function all_orders_in_pharmacy()
  {
    $pharmacy=Auth::id();
    $orders=Order::get()->where('user_id',$pharmacy);
    if($orders==null)
    {
      return response()->json(
        [
          'status'=>0,
            'message'=>'there is no orders in the pharmacy',
            'data'=>$orders
        ]
        );
    }
    return response()->json(
        [
          'status'=>1,
            'message'=>'orders retured successfully',
            'data'=>$orders
        ]
        );
  }

//front should sent id with status & pay_status UNTIL NOW !

// In preparation   Delivery is in progress    delivered

  public function edit_status(request $request)
  {
    //delete order from pharmacy when reseved
    $order=Order::get()->where('id',$request->id)->first();
  
  
  
    if($order==null)
    {
       return response()->json(
      [
        'status'=>0,
          'message'=>'the order not found',
          'data'=>$order
      ]
      );
    }
    $order->status=$request->status;
    $order->pay_status=$request->pay_status;
    $order->save();
if($order->status=="delivered")
{
  $json_file=$order->content;

 $content=json_decode($json_file,TRUE);
// dd($content);
foreach($content as $key )
{
  //dd($key->id);
$product=Product::where('id',$key->id)->get();
//dd($product);
$product->quantity=$product->quantity-$key->quantity;
$product->save();
//send notifaction to the warehouse
}
}
    return response()->json(
      [
        'status'=>1,
          'message'=>'orders updated successfully',
          'data'=>$order
      ]
      );
  }

  public function edit_status_pharmacy(request $request)
  {
  }
  public function delete_order_pharmacy(request $request)
  {
  }

  public function order_info(request $request)
  {
  }


}