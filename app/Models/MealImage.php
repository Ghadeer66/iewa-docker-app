<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealImage extends Model
{

    protected $table = 'meals_images';

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
