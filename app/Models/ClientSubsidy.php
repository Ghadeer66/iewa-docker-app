<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSubsidy extends Model
{
    protected $fillable = ['user_id', 'granted_by', 'max_price', 'percentage', 'starts_at', 'ends_at'];
}
