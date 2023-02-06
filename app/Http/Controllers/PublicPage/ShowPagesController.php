<?php

namespace App\Http\Controllers\PublicPage;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ShowPagesController extends Controller
{
    public function showIndex() {
        return view('index', ['orders' => Order::where('order_status', '=', 2)->latest()]);
    }
    public function showAbout() {
        return view('about');
    }
}
