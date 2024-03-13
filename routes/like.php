<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These Routes are for the use to Like or remove his like on a Recipe
| To Like     : http://localhost:8000/api/recipe/like
| To UnLike   : http://localhost:8000/api/recipe/unlike
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'recipe'
], function ($router) {

    Route::post('/like',   [LikeController::class, 'likeRecipe']);
    Route::post('/unlike', [LikeController::class, 'unLikeRecipe']);

});