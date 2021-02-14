<?php

namespace App\Models;

use App\User;
use DateTimeInterface;
use App\Events\Message\NewMessageEvent;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['from', 'to', 'read', 'text'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $dispatchesEvents = [
        'created' => NewMessageEvent::class,
    ];

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

    // Methods
    public function loadWithFromAndTo() {
        return $this->load([
            'fromUser' => function ($queryFrom) {
                $queryFrom->select('id', 'file_id', 'firstname', 'secondname', 'lastname')
                            ->with('profileImage:id,filename,path');
            },
            'toUser' => function ($queryTo) {
                $queryTo->select('id', 'file_id', 'firstname', 'secondname', 'lastname')
                        ->with('profileImage:id,filename,path');
            }
        ]);
    }
}
