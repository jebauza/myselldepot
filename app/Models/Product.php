<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['name', 'description', 'stock', 'price', 'categorie_id'];

    //Scopes
    public function scopeName($query, $name)
    {
        if($name){
            return $query->where('name', 'like', "%$name%");
        }
    }

    public function scopeDescription($query, $description)
    {
        if($description){
            return $query->where('description', 'like', "%$description%");
        }
    }

    public function scopeCategoryIds($query, $category_ids)
    {
        if(is_array($category_ids) && !empty($category_ids)){
            return $query->whereIn('categorie_id', $category_ids);
        }
    }

    //Relations
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'details_orders', 'product_id', 'order_id')
                    ->withPivot('order_id','product_id','quantity','price')->withTimestamps();;
    }
}
