<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These Routes are for the use to Like or remove his like on a Recipe
| To Get all Recipes            : GET   http://localhost:8000/api/recipes
| To Get One Recipe By ID       : GET   http://localhost:8000/api/recipes/{id}
| To Get Recipes By Category    : GET   http://localhost:8000/api/recipes/{categoryName}
| To Get Recipes By Ingredients : POST  http://localhost:8000/api/recipes/ingredients
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
| To Create a New Recipe   : POST    http://localhost:8000/api/recipe
| To Remove Recipe By ID   : DELETE  http://localhost:8000/api/recipe/{id}
| To Update Recipe By ID   : PUT     http://localhost:8000/api/recipe/{id}
*/
Route::group([
    'middleware' => 'api'
], function ($router) {

    Route::get('/recipes'                ,[RecipeController::class, 'getAllRecipes']);
    Route::get('/recipes/{categoryName}' ,[RecipeController::class, 'getRecipesByCategory']);
    Route::post('/recipes/ingredients'   ,[RecipeController::class, 'getRecipesByIngredients']);
    Route::get('/recipes/{id}'           ,[RecipeController::class, 'getOneRecipeById']);


    //-------- For Admins -------------
    // --------------------------------
    Route::post('/recipe'               ,[RecipeController::class, 'createRecipe']);
    Route::delete('/recipe/{id}'        ,[RecipeController::class, 'deleteRecipe']);
    Route::put('/recipe/{id}'           ,[RecipeController::class, 'updateRecipe']);


    Route::post('/steps'               ,[RecipeController::class, 'createSteps']);
    Route::post('/ingredients'         ,[RecipeController::class, 'createIngredients']);

    Route::delete('/steps/{id}'        ,[RecipeController::class, 'deleteStep']);
    Route::delete('/ingredients/{id}'  ,[RecipeController::class, 'deleteIngredient']);


    
    

});