<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['from', 'to', 'read', 'text'];

    //Scopes
    public function scopeFromAndTo($query, $from_id, $to_id)
    {
        if($from_id && $to_id){
            return $query->where(function($query1) use($from_id, $to_id){
                            $query1->where('from', $from_id)
                                    ->where('to', $to_id);
                    })
                    ->orWhere(function($query2) use($from_id, $to_id){
                        $query2->where('from', $to_id)
                                    ->where('to', $from_id);
                    });
        }
    }

    //Relaciones
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }
}
