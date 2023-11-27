<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function show_all_reports_warehouse()
{
    $user = auth()->user();
    $orders = Order::where('warehouse_id', $user->id)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('status','done')
                ->get();

    $reportContent = $orders->toJson();
    $report=Report::create([
        'name' => $year . '-' . $month,
        'warehouse_id' => $user->id,
        'content' => $reportContent
    ]);
    return response()->json(
        [
            'status'=>1,
            'message'=>'report show successfully',
            'data'=>$report
        ]
        );
}

public function create_reports()
{

        $user = Auth::user();

        $doneOrders = Order::where('user_id', $user->id)
                            ->where('status', 'done')
                            ->get();

        $reportContent = [];
        foreach($doneOrders as $order){
            $reportContent[] = $order->content;
        }

        $report = new Report;
        $report->user_id = $user->id;
        $report->content = json_encode($reportContent);
        $report->date = now();
        $report->save();

        return response()->json(
            [
                'status'=>1,
                'message'=>'report created successfully',
                'data'=>$report
            ]
            );
        }

}
