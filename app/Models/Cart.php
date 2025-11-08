<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'meal_id', 'date', 'price', 'quantity'
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id', 'id');
    }
}
