<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['order_number', 'comments', 'customer_id', 'user_id', 'total', 'state'];
}
