<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;

class UpdateOrderController extends Controller
{
    public function sussesDeliveries(Order $order) {
        $order->fill([
           'order_status' => 2
        ]);
        $delivery = $order->delivery()->where('order_id', $order->id)->firstOrFail();
        $delivery->fill([
            'order_is_completed' => true
        ]);
        $delivery->save();
        $order->save();
        return redirect()->route('user.orders.completed.detail', $order->id);
    }
}
