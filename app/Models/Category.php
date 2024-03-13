<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Recipe;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    public function Recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class);
    }

}
