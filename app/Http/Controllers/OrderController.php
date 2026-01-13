<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //direct order list page
    public function OrderList(){

        // join user table -> user table.id = order table = user_id
        $order=Order::select('orders.*','users.name as user_name')
        ->leftJoin('users','users.id','orders.user_id')
        ->get();

        // output data format as array
        // dd($order->toArray());
        return view('admin.order.list',compact('order'));
    }
}
