<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Category;
use App\Models\Step;
use App\Models\Ingredient;
use App\Models\Review;
use App\Models\Image;

class Recipe extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'description',
        'origin',
        'difficulty',
        'time',
        'views'
    ];

    public function Categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function Steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }

    public function Ingreients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function Likes():HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function Reviews():HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function Images():HasMany
    {
        return $this->hasMany(Image::class);
    }


    // $recipeData = [
    //     'name' => 'Your Recipe Name',
    //     // Add other recipe data
    // ];
    
    // $categoryIds = [1, 2, 3]; // Assuming you have the IDs of selected categories
    
    // // Create a new recipe instance
    // $recipe = Recipe::create($recipeData);
    
    // // Attach categories to the recipe
    // $recipe->categories()->attach($categoryIds);




}
