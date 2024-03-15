<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These Routes are for the use to Like or remove his like on a Recipe
| To Review          : POST     http://localhost:8000/api/recipe/review
| To Delete Review   : DELETE   http://localhost:8000/api/recipe/review/{id}
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'recipe'
], function ($router) {

    Route::post('/review'        , [ReviewController::class, 'createReview']);
    Route::delete('/review/{id}' , [ReviewController::class, 'deleteReview']);

});