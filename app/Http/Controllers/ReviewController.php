<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class ReviewController extends Controller
{
    // 'id',
    // 'recipe_id',
    // 'user_id',
    // 'comment',
    // 'rating',
    // 'image_url'

    public function __construct() {
        $this->middleware('auth:api');
    }

    //----- Create Review
    public function createReview(Request $request) {

        $validator = $request->validate([
            'recipe_id' => 'required',
            'comment'   => 'required|string',
            'rating'    => 'required',
            'image'     => 'nullable'
        ]);

        if($validator){

            $review = Review::create([
                "id"         => Uuid::uuid4()->toString(),
                "user_id"    => Auth::user()->id,
                "recipe_id"  => $request->recipe_id,
                "comment"    => $request->comment,
                "rating"     => $request->rating,
            ]);

            return response()->json(['message' => 'You Reviewed the recipe successfully!'], 201);

        }

        return response()->json(["error"=>"There is an issue!"], 422);
    }

    //----- Delete Review
    public function deleteReview($id) {

        $review = Review::where('id',$id)->get();
        $review->delete();
        return response()->json(['message' => 'You Deleted the Review Successfully!'], 201);

    }
}
