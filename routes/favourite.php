<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavouriteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These Routes are for the use to Like or remove his like on a Recipe
| To Like     : http://localhost:8000/api/recipe/save
| To UnLike   : http://localhost:8000/api/recipe/unsave
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'recipe'
], function ($router) {

    Route::post('/save',   [FavouriteController::class, 'SaveRecipe']);
    Route::post('/unsave', [FavouriteController::class, 'unSaveRecipe']);

});