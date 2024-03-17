<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Recipe;
use App\Models\Step;
use App\Models\Ingreient;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class RecipeController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api',['except' => ['getOneRecipeById', 'getAllRecipes']]);
    }


    public function createRecipe(Request $request) {

        $validator = $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'origin'      => 'required|string',
            'difficulty'  => 'required',
            'time'        => 'required',
            // 'steps'       => 'required',
            // 'ingredients' => 'required',
            // 'images'      => 'nullable',
            'categories'  => 'required|array'
        ]);

        if ($validator) {

            $Recipe_id = Recipe::create([
                "id"           => Uuid::uuid4()->toString(),
                "title"        => $request->title,
                "description"  => $request->description,
                "origin"       => $request->origin,
                "difficulty"   => $request->difficulty,
                "time"         => $request->time
            ])->id;

            // Save Recipe Steps
            // for($i=0;$i<count($request->steps);$i++) {
            //     $step = Step::create([
            //         "id"            => Uuid::uuid4()->toString(),
            //         "recipe_id"     => $Recipe_id,
            //         "step_number"   => $i+1,
            //         "description"   => $request->steps[$i]["description"],
            //         "duration_min"  => $request->steps[$i]["duration_min"]
            //     ]);
            // }

            // Save Recipe Ingredients
            // for($i=0;$i<count($request->ingredients);$i++){
            //         Ingredient::create([
            //             "id"        => Uuid::uuid4()->toString(),
            //             "recipe_id" =>$Recipe_id,
            //             "name"      =>$request->ingredients[$i]["name"],
            //             "quantity"  =>$request->ingredients[$i]["quantity"],
            //         ]);
            // }

            // Save Recipe Images
            // for($i=0;$i<count($request->images);$i++){

            //     if(isset($request["images"][$i])){
    
            //         $filename = Str::random(32).".".$request["images"][$i]->getClientOriginalExtension();
            //         $request["images"][$i]->move('uploads/recipe', $filename);
        
        
            //         Image::create([
            //             "id"         => Uuid::uuid4()->toString(),
            //             "recipe_id"  =>$Recipe_id,
            //             "image_url"  =>$filename
            //         ]);
            //     }
            // }

            // Save Recipe Categories
            for($i=0;$i<count($request->categories);$i++){

                if(isset($request["categories"][$i])){
                    DB::table('category_recipe')->insert([
                        "recipe_id"    =>$Recipe_id,
                        "category_id"  =>$request->categories[$i]
                    ]);
                }
            }
            return response()->json(['message' => 'You Saved the Recipe successfully!'], 201);
        }

        return response()->json(["error"=>"There is an issue!"], 422);

    }

    // Not yet 
    public function updateRecipe(Request $request,$id) {}

    public function deleteRecipe($id) {

        $recipe = Recipe::where('id',$id)->get();
        $recipe->delete();

        return response()->json(['message' => 'You Removed the Recipe successfully!'], 201);

    }

    public function getAllRecipes() {
        $recipe_final = [];
        $recipes = Recipe::all();

        foreach($recipes as $recipe){
            $rating_list = [];
            // if($recipe->Reviews){
            foreach($recipe->reviews as $review){
                array_push($rating_list,$review->rating);
            }
        // }

            $rating =count($rating_list) == 0? 0:array_sum($rating_list)/count($rating_list);
            array_push($recipe_final,[
                "recipe" =>$recipe,
                // "images" =>$recipe->images,
                "rating" =>$rating,
                // "likes"  =>count($recipe->likes),
                // "likes"  =>$recipe->likes,
                // "reviews" => $recipe->Reviews
            ]);
        }

        return $recipe_final;
    }

    public function getRecipesByCategory($categoryName){
        $recipes = Recipe::whereHas('categories', function ($query) use ($categoryName) {
            $query->where('name', $categoryName);
        })->get();

        return $recipes;
    }

    public function getOneRecipeById($id){

        $recipe = Recipe::where('id',$id)->first();
        $reviews = [];
        $rating_list = [];
        foreach($recipe->reviews as $review){
            array_push($reviews,["review"=>$review,"user"=>$review->user]);

        };
        $rating = 0;
        if(count($recipe->reviews)>0){
            foreach($recipe->reviews as $review){
                array_push($rating_list,$review->rating);
            };

            $rating = floatval(array_sum($rating_list)/count($rating_list));
        }

        dd($recipe->toSql());
        // return $recipe;

        // return [
        //     "recipe"       => $recipe,
        //     "reviews"      => $reviews,
        //     "rating"       => $rating,
        //     // "likes"        => count($Recipe->likes),
        //     "steps"        => Step::where('recipe_id',$recipe->id)->get(),
        //     // "ingredients"  => $Recipe->ingreients,
        //     // "images"       => $Recipe->images
        // ];

    }

    public function getRecipesByIngredients(Request $request){

        $validator = $request->validate([
            "ingredientNames" => "required|string"
        ]);

        $ingredientNames = explode(" ", $request->ingredientNames);

        $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredientNames) {
            $query->whereIn('name', $ingredientNames);
        })->get();

        return $recipes;
    }




    public function createSteps(Request $request) {
        $validator = $request->validate([
            "recipe_id" => "required",
            "steps"     => "required|array"
        ]);

        if($validator){
            for($i=0;$i<count($request->steps);$i++) {
                $step = Step::create([
                    "id"            => Uuid::uuid4()->toString(),
                    "recipe_id"     => $request->recipe_id,
                    "step_number"   => $i+1,
                    "description"   => $request->steps[$i]["description"],
                    "duration_min"  => $request->steps[$i]["duration_min"]
                ]);
            }
            return response()->json(['message' => 'You Create The Recipe Steps Successfully!'], 201);

            }

            return response()->json(["error"=>"There is an issue!"], 422);
    }

    public function deleteStep($id) {
        $step = Step::where('id',$id)->get();
        $step->delete();
        return response()->json(['message' => 'You Delete The Recipe Steps Successfully!'], 201);

    }

    public function createIngredients(Request $request) {
        $validator = $request->validate([
            "recipe_id"    => "required",
            "ingredients"  => "required|array"
        ]);

        if($validator){
            for($i=0;$i<count($request->ingredients);$i++) {
                $ingredient = Ingreient::create([
                    "id"           => Uuid::uuid4()->toString(),
                    "recipe_id"    => $request->recipe_id,
                    "name"         => $request->ingredients[$i]["name"],
                    "quantity"     => $request->ingredients[$i]["quantity"],
                ]);
            }
            return response()->json(['message' => 'You Create The Recipe ingred Successfully!'], 201);

            }

            return response()->json(["error"=>"There is an issue!"], 422);
    }
    public function deleteIngredient($id) {
        $ingredient = Ingreient::where('id',$id)->get();
        $ingredient->delete();
        return response()->json(['message' => 'You Delete The Recipe Steps Successfully!'], 201);

    }


    public function createImage(Request $request) {

        $validator = $request->validate([
            "recipe_id"    => "required",
            "image"        => "required"
        ]);

        if($validator){
            
                // if(isset($request["images"][$i])){
    
                    if ($request->hasFile('image')) {
                        $image = $request->file('image');
                        $imageName = time() . '_' . $image->getClientOriginalName();
                        $image->move(public_path('uploads'), $imageName);

                        Image::create([
                            "id"         => Uuid::uuid4()->toString(),
                            "recipe_id"  =>$request->recipe_id,
                            "image_url"  =>$imageName
                        ]);
            
                        return response()->json(['message' => 'Image uploaded successfully', 'image' => $imageName], 200);
                    } else {
                        return response()->json(['message' => 'No image uploaded'], 400);
                    }
        
        

                // }

            return response()->json(['message' => 'You Create The Recipe Image Successfully!'], 201);

            }

            return response()->json(["error"=>"There is an issue!"], 422);

    }
}
