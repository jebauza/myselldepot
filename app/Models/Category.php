<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'description'];

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

    //Relaciones
    public function products()
    {
        return $this->hasMany(Product::class, 'categorie_id', 'id');
    }
}
