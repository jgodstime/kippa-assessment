<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    public function __construct(protected Order $order, protected OrderItem $orderItem)
    {
    }

    public function getOrders(array $data)
    {
        $orders = $this->order->with('purchaser.referrer.referrers', 'orderItems');

        if(isset($data['from_date']) && !empty($data['from_date']) && isset($data['to_date']) && !empty($data['to_date']) ){
            $orders->dateRange(Carbon::parse($data['from_date']), Carbon::parse($data['to_date']));
        }

        if(isset($data['user']) && !empty($data['user']) ){
            $orders->ofUser($data['user']);
        }

        $newOrders = $orders->get()->map(function($order){

            $order['purchaser']['referrer_count'] = count($order?->purchaser?->referrer?->referrers ?? []);
            $order['percentage'] = $this->getPercentage($order['purchaser']['referrer_count']);
            $order['order_total'] = $this->getOrderTotal($order['orderItems']);
            $order['commission'] = ($order['percentage']/100) * $order['order_total'];

            return $order;
        });

        return $this->paginate($newOrders);
    }


    public function getOrderItemsByOrderId(int $orderid)
    {
        $order = $this->orderItem->where('order_id', $orderid)->with('product')->get();

        return $order;
    }

    public function topSelling()
    {
        $users = User::whereHas('referrers')
                ->limit(100)
                ->get()
                ->reject(function($user){
                    return $user->is_distributor === false;
                })->sortBy(function($value, $key) {
                    return ($value['sales']);
                }, SORT_REGULAR, true)
                ->values();

        return $this->paginate($users);
    }


    public function getOrderTotal($orderItems):int|float
    {
        return collect($orderItems)->reject(function($newOrderItem){
            return !$newOrderItem->product; // reject if the orderitem is not tied to a product
        })->sum(function($item){
            return $item->product->price * $item->qantity;
        });
    }


    public function getPercentage(int $value): int
    {
        if($value >= 0 && $value <= 4){
            return 5;
        }

        if($value >= 5 && $value <= 10){
            return 10;
        }

        if($value >= 11 && $value <= 20){
            return 15;
        }

        if($value >= 21 && $value <= 30){
            return 20;
        }

        if($value >= 31 ){
            return 30;
        }

        return 0;
    }

}
