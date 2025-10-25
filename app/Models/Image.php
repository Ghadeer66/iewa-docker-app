<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['url', 'alt', 'extra'];

    public function getUrlAttribute()
    {
        return asset(str_replace('/admin', '', $this->attributes['url']));
    }
}


