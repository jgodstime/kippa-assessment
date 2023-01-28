<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFilterRequest;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function index(OrderFilterRequest $request)
    {
         $orders = $this->orderService->getOrders($request->validated());

        return view('welcome', ['orders' => $orders]);
    }

    public function getOrderItemsByOrderId($orderId)
    {
        $ordersItems = $this->orderService->getOrderItemsByOrderId($orderId);

        return response()->json($ordersItems);
    }


    public function topSelling()
    {
        $topSellings = $this->orderService->topSelling();

        return view('top-selling', ['topSellings' => $topSellings]);
    }


}
