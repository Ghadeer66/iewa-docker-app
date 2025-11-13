<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPurchaseCredit extends Model
{
    protected $fillable = ['user_id', 'amount', 'valid_days', 'starts_at'];
}

