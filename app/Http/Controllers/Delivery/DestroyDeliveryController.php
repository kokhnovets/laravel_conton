<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestroyDeliveryController extends Controller
{
    public function destroyDeliveries(Order $order) {
        $statusesExists = $order->statuses()->exists();
        if ($statusesExists) {
            return redirect()->back();
        } else {
            $delivery = $order->delivery()->firstOrFail();
            $delivery->delete();
            $order->fill([
                'order_status' => 0
            ]);
            $order->save();
            return redirect()->route('user.orders.posted.detail', $order->id);
        }
    }
}
