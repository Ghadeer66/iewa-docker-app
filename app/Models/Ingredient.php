<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'amount', 'unit'];

    protected $casts = [
        'amount' => 'integer',
    ];

    /**
     * Relationship with meals
     */
    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'meal_ingredients');
    }
}
