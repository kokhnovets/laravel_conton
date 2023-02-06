<?php

namespace App\Http\Controllers\Delivery;

use App\Events\DeliveryStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\StoreStatusRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class StoreStatusController extends Controller
{
    public function storeStatuses(StoreStatusRequest $request,Order $order) {
        $validated = $request->validated();
        if ($validated) {
            $validated['order_id'] = $order->id;
            $order->statuses()->create($validated);
            return response()->json(["status" => true]);
        } else {
            return response()->json([
                'error' => $validated->errors()
            ], 422);
        }
    }
}
