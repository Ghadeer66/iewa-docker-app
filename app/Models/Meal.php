<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'calories',
        'price',
        'is_vegan',
        'kcal',
        'nutritional_informations',
        'contraindications',
        'consumable_items',
    ];

    protected $casts = [
        'nutritional_informations' => 'array',
        'contraindications' => 'array',
        'consumable_items' => 'array',
        'is_vegan' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Relationship with categories
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'meal_categories');
    }

    /**
     * Relationship with types
     */
    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'meal_type');
    }

    /**
     * Relationship with ingredients
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredients');
    }

    /**
     * Relationship with images
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'meals_images');
    }
}
