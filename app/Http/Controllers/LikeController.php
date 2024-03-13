<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class LikeController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function likeRecipe(Request $request){
        $validator = $request->validate([
            'recipe_id' => 'required|string'
        ]);

        if ($validator) {

            $like = Like::create([
                "id"         => Uuid::uuid4()->toString(),
                "user_id"    => Auth()->user()->id,
                "recipe_id"  => $request->recipe_id
            ]);

            return response()->json(['message' => 'You liked the recipe successfully!'], 201);
        }

        return response()->json(["error"=>"There is an issue!"], 422);
    }



    public function unLikeRecipe(Request $request){
        $validator = $request->validate([
            'recipe_id' => 'required|string'
        ]);


        if ($validator) {

            $like = Like::where('user_id',Auth()->user()->id)->where('recipe_id',$request->recipe_id)->get();

            $like->delete();

            return response()->json(['message' => 'You Unliked the recipe successfully!'], 201);
        }

        return response()->json(["error"=>"There is an issue!"], 422);
    }
}
