<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class FavouriteController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function SaveRecipe(Request $request){
        $validator = $request->validate([
            'recipe_id' => 'required|string'
        ]);

        if ($validator) {

            $favourite = Favourite::create([
                "id"         => Uuid::uuid4()->toString(),
                "user_id"    => Auth::user()->id,
                "recipe_id"  => $request->recipe_id
            ]);

            return response()->json(['message' => 'You Saved the Recipe successfully!'], 201);
        }

        return response()->json(["error"=>"There is an issue!"], 422);
    }


    public function unSaveRecipe(Request $request){
        $validator = $request->validate([
            'recipe_id' => 'required|string'
        ]);


        if ($validator) {

            $favourite = Favourite::where('user_id',Auth::user()->id)->where('recipe_id',$request->recipe_id)->get();

            $favourite->delete();

            return response()->json(['message' => 'You UnSaved the Recipe successfully!'], 201);
        }

        return response()->json(["error"=>"There is an issue!"], 422);
    }
}
