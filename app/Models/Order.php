<?php

namespace App\Models;

use App\User;
use App\Models\Product;
use App\Models\Customer;
use App\Events\Order\OrderSavedEvent;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivots\DetailsOrdersPivot;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['order_number', 'comments', 'customer_id', 'user_id', 'total', 'state'];

    //Scopes
    public function scopeCustomerName($query, $name)
    {
        if($name){
            return $query->whereHas('customer', function (Builder $query) use($name){
                $query->name($name);
            });
        }
    }

    public function scopeCustomerDocument($query, $document)
    {
        if($document){
            return $query->whereHas('customer', function (Builder $query) use($document){
                $query->document($document);
            });
        }
    }

    public function scopeOrderNumber($query, $order_number)
    {
        if($order_number){
            return $query->where('order_number', 'like', "%$order_number%");
        }
    }

    public function scopeState($query, $state)
    {
        if($state){
            return $query->where('state', $state);
        }
    }

    //Relations
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'details_orders', 'order_id', 'product_id')
                    ->using(DetailsOrdersPivot::class)
                    ->withPivot('order_id','product_id','quantity','price')->withTimestamps();
    }
}
