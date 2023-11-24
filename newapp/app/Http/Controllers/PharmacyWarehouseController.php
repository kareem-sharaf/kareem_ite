<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class PharmacyWarehouseController extends Controller
{
    public function index()
    {
        $warehouse = User::where('admin', true)->get('name');
        $message = "this is the all warehouses";

        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $warehouse,
        ]);
    }
}
