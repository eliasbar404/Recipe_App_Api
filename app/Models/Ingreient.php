<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;

class Ingreient extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'recipe_id',
        'name',
        'quantity',
        'image_url',
    ];


    public function Recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
