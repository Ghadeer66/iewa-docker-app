<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['title', 'description', 'price', 'kcal', 'type_id'];

    public function mealImage()
    {
        return $this->hasOne(MealImage::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->mealImage && $this->mealImage->image) {
            return asset($this->mealImage->image->url);
        }
        return null;
    }
}
