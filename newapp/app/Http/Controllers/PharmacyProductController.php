<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Illuminate\Support\Facades\Auth;

class PharmacyProductController extends Controller
{
    public function index_pharmacy()
    {
        $product = Product::get('name_scientific');
        $message = "this is the all products";

        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $product,
        ]);
    }


    public function special_index_pharmacy($id)
    {

        $product = Product::where('warehouse_id', $id)->get('name_scientific');
        $message = "this is the all products";
        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $product,
        ]);
    }





    public function show_pharmacy($name)
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
}
