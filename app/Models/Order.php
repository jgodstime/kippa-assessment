<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * Get the purchaser that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaser()
    {
        return $this->belongsTo(User::class, 'purchaser_id', 'id');
    }

    /**
     * Get all of the orderItems for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class)->with('product');
    }

    public function scopeDateRange($query, Carbon $startDate, Carbon $endDate){
        return $query
            ->whereDate('order_date', '>=',$startDate)
            ->whereDate('order_date','<=',$endDate);
    }

    public function scopeOfUser($query, $user)
    {
        return $query
            ->whereIn('purchaser_id', function ($query) use ($user) {
                return $query
                    ->select('id')
                    ->from('users')
                    ->where('first_name', 'like', "%{$user}%")
                    ->orWhere('last_name', 'like', "%{$user}%")
                    ->orWhere('username', 'like', "%{$user}%")
                    ->orWhere('id', 'like', "%{$user}%");
            });
    }

}


