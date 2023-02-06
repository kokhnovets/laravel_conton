<?php

namespace App\Http\Controllers\Travel\Offer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Travel\Offer\StoreOfferRequest;
use App\Models\OfferForDelivery;
use App\Models\Order;
use Illuminate\Http\Request;

class StoreOfferController extends Controller
{
    public function storeOffer(Order $order, StoreOfferRequest $request) {
        $validated = $request->validated();
        if ($validated) {
            $validated['user_id'] = auth()->id();
            $validated['order_id'] = $order->id;
            $order->offers()->create($validated);
            return response()->json(["status" => true]);
        } else {
            return response()->json([
                'error' => $validated->errors()
            ], 422);
        }
    }
}
