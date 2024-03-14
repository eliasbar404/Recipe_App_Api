<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavouriteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These Routes are for the use to Like or remove his like on a Recipe
| To Save           : POST  http://localhost:8000/api/recipe/save
| To UnSave         : POST  http://localhost:8000/api/recipe/unsave
| Get Saved Recipes : GET   http://localhost:8000/api/recipe/saved
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'recipe'
], function ($router) {

    Route::get('/saved',   [FavouriteController::class, 'getFavouriteRecipes']);
    Route::post('/save',   [FavouriteController::class, 'SaveRecipe']);
    Route::post('/unsave', [FavouriteController::class, 'unSaveRecipe']);

});