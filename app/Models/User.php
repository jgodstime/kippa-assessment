<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

      protected $appends = [
        'is_distributor',
        'sales'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIsDistributorAttribute(): bool
    {
        return $this->userCategory()->whereHas('category', function($query){
            $query->where('name', 'Distributor');
        })->exists();
    }

    // public function getReferrerCountAttribute(): bool
    // {
    //     return count($this->referrers);
    // }

    public function getFullNameAttribute()
    {
        return $this->first_name. ' '. $this->last_name;
    }

    public function getSalesAttribute()
    {
        if($this->is_distributor === true){
            $saless = Order::with('orderItems.product')->where('purchaser_id', $this->id)->get();

            $total = 0;

            foreach($saless as $sales){
                foreach($sales->orderItems as $orderItem){
                    $total += $orderItem->product->price * $orderItem->qantity;
                }
            }

            return $total;
        }else{
            return 0;
        }

    }

    /**
     * Get the referal associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function referrer()
    {
        return $this->hasOne(User::class, 'referred_by')->with('userCategory');
    }

    /**
     * Get all of the userCategory for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCategory()
    {
        return $this->hasOne(UserCategory::class)->with('category');
    }

    /**
     * Get all of the userCategory for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrers()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /**
     * Get all of the orders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'purchaser_id');
    }


}
