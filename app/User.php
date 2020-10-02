<?php

namespace App;

use App\Models\File;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'secondname', 'lastname', 'username', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['profileImage'];

    protected $appends = ['fullName'];

    //Attributes
    function getFullNameAttribute()
    {
        return $this->firstname .' '.($this->secondname ?? '').' '. $this->lastname;
    }

    //Scopes
    public function scopeEmail($query, $email)
    {
        if($email){
            return $query->where('email', 'like', "%$email%");
        }
    }

    public function scopeUserName($query, $username)
    {
        if($username){
            return $query->where('username', 'like', "%$username%");
        }
    }

    public function scopeName($query, $name)
    {
        if($name){
            return $query->whereRaw("CONCAT_WS(' ', firstname, secondname, lastname) like '%$name%'");
        }
    }

    public function scopeState($query, $state)
    {
        if($state){
            return $query->where('state', $state);
        }
    }

    //Relaciones
    public function profileImage()
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }
}
