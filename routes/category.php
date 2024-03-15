<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These Routes are for the use to Like or remove his like on a Recipe
| To Get All        : GET     http://localhost:8000/api/categories
| To Create         : POST    http://localhost:8000/api/category
| To Delete         : DELETE  http://localhost:8000/api/category/{id}
*/
Route::group([
    'middleware' => 'api',
], function ($router) {

    Route::get('/categories'       , [CategoryController::class, 'getAllCategories']);
    Route::post('/category'        , [CategoryController::class, 'createCategory']);
    Route::delete('/category/{id}' , [CategoryController::class, 'deleteCategory']);

});