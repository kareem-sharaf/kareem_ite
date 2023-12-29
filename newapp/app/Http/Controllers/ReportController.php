<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Report;

use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //FIX THE VALIDATE ERROR MESSAGE
    //REPLACE ID WITH NAME
    public function show_all_reports(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:'.date('Y')
        ]);

        if ($validator->fails())
            return response()->json([
                'status' => 0,
                'message' => 'inputs failed',
            ]);
        $month = $request->input('month');
        $year = $request->input('year');
        $orders = Order::where('warehouse_id',$user->id)
                        ->orWhere('user_id', $user->id)
                        ->where('year',$year)
                        ->where('month', $month)
                        ->get();
        $reportContent = $orders->toJson();
        if ($user->admin){
        $warehouse_name=User::where('id',$user->id)->get('name')->first();
        $report=Report::create([
        'warehouse_id' => $user->id,
        'warehouse_name' => $warehouse_name->name,
        'content' =>$reportContent
    ]);}
    if (!$user->admin){
        $pharmacy_name=User::where('id',$user->id)->get('name')->first();
        $report=Report::create([
        'pharmacy_id' => $user->id,
        'pharmacy_name' => $pharmacy_name->name,
        'content' =>$reportContent
    ]);}
    return response()->json(
        [
            'status'=>1,
            'message'=>'report showing successfully',
            'data'=>$report
        ]
    );
}

}
