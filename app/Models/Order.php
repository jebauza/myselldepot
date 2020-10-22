<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['order_number', 'comments', 'customer_id', 'user_id', 'total', 'state'];

    //Relations
    public function customer()
    {
        return $this->belongsTo('App\User', 'foreign_key', 'other_key');
    }
}
