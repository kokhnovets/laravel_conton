<?php

namespace App\Http\Controllers\Travel;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function showOrder(Order $order) {
        $orderExists = Order::where('id', $order->id)->where('user_id', auth()->id());
        if ($orderExists->exists()) {
            return redirect()->back();
        }
        return view('travel.order_details', compact('order'));
    }
}
