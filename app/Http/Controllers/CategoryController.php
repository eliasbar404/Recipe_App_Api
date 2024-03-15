<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Ramsey\Uuid\Uuid;

class CategoryController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function getAllCategories() {
        $categories = Category::all();
        return $categories;
    }

    public function createCategory(Request $request) {

        $validator = $request->validate([
            "name"         => "required|string",
            "description"  => "required|string"
        ]);

        if ($validator) {

            $category = Category::create([
                "id"           => Uuid::uuid4()->toString(),
                "name"         => $request->name,
                "description"  => $request->description,
            ]);

            return response()->json(['message' => 'You Create the Category successfully!'], 201);
        }


        return response()->json(["error"=>"There is an issue!"], 422);
    }

    public function deleteCategory($id) {
        $category = Category::where('id',$id)->get();
        $category->delete();
        return response()->json(['message' => 'You Deleted The Category Successfully!'], 201);
    }
}
