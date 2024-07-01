<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = [
            ['id' => '#703', 'date' => '8 Sep, 2020', 'total' => '$135.00 (5 Products)', 'status' => 'Processing'],
            ['id' => '#130', 'date' => '22 Oct, 2020', 'total' => '$250.00 (4 Products)', 'status' => 'Completed'],
        ];

        return response()->json($orders);
    }
    // {
    //     $orders = Order::where('user_id', auth()->id())->get();
    //     return response()->json($orders);
    // }

    public function show($id)
    {
        $order = ['id' => $id, 'date' => '22 Oct, 2020', 'total' => '$250.00 (4 Products)', 'status' => 'Completed'];
        return response()->json($order);
    }
    // {
    //     $order = Order::where('user_id', auth()->id())->findOrFail($id);
    //     return response()->json($order);
    // }
}
