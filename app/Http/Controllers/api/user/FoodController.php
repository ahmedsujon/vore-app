<?php

namespace App\Http\Controllers\api\user;

use Exception;
use App\Models\Food;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    public function foods(Request $request)
    {
        $pagination_value = $request->per_page ? $request->per_page : 10;
        $foods = Food::where('name', 'like', '%'.$request->search_term.'%')->where('status', 1)->paginate($pagination_value);

        return response()->json($foods);
    }

    public function addFood(Request $request)
    {
        $rules = [
            'name' => 'required',
            'quantity' => 'required',
            'serving_size' => 'required',
            'calories' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
            'protein' => 'required',
            'image' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $food = new Food();
            $food->added_by = 'user';
            $food->user_id = api_user()->id;
            $food->name = $request->name;
            $food->slug = Str::slug($request->name).'-'.Str::lower(Str::random(5));
            $food->calories = $request->calories;
            $food->crabs = $request->crabs;
            $food->fat = $request->fat;
            $food->protein = $request->protein;
            $food->barcode = $request->barcode;
            $food->image = uploadFile($request->image, 'foods');
            $food->save();

            return response()->json(['result' => 'true', 'message' => 'Food added successfully']);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
