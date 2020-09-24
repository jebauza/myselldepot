<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = ['path','filename', 'created_by', 'updated_by'];

    protected $appends = ['url'];

    //Attributes
    function getUrlAttribute()
    {
        return Storage::exists($this->path) ? asset(Storage::url($this->path)) : null;
    }
}
