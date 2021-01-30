<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['name', 'lastname', 'document', 'phone', 'email'];

    protected $appends = ['fullName'];

    //Attributes
    function getFullNameAttribute()
    {
        return $this->name .' '. $this->lastname;
    }

    //Scopes
    public function scopeName($query, $name)
    {
        if($name){
            return $query->whereRaw("CONCAT_WS(' ', name, lastname) like '%$name%'");
        }
    }

    public function scopeDocument($query, $document)
    {
        if($document){
            return $query->where('document', 'like', "%$document%");
        }
    }

    //Relations
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
}
