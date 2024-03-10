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
    public function getFoods(Request $request)
    {
        // $pagination_value = $request->per_page ? $request->per_page : 10;
        $foods = Food::select('id', 'name', 'slug', 'calories', 'protein', 'crabs', 'fat', 'nutrations', 'barcode', 'images', 'created_at')->where('name', 'like', '%'.$request->search_term.'%')->where('status', 1)->get();

        foreach ($foods as $food)
        {
            $imgs = [];
            foreach ($food->images as $image) {
                $imgs[] = url('/').'/'.$image;
            }
            $food->images = $imgs;
        }

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
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getFood = Food::where('food_unique_id', $request->food_unique_id)->first();

            $demo_nutations = [
                "dietary_fiber" => 0,
                "total_sugars" => 0,
                "saturated_fat" => 0,
                "monounsaturated_fat" => 0,
                "polyunsaturated_fat" => 0,
                "trans_fat" => 0,
                "cholesterol" => 0,
                "sodium" => 0,
                "salt" => 0,
                "water" => 0,
                "alcohol" => 0,
                "vitamin_B7" => 0,
                "vitamin_C" => 0,
                "vitamin_D" => 0,
                "vitamin_E" => 0,
                "vitamin_K" => 0,
                "calcium" => 0,
                "iron" => 0,
                "magnesium" => 0,
                "potassium" => 0,
                "zinc" => 0
            ];

            if (!$getFood) {
                $food = new Food();
                $food->added_by = 'user';
                $food->food_unique_id = $request->food_unique_id ? $request->food_unique_id : 'vore_food_' . Str::lower(Str::random(15));
                $food->user_id = api_user()->id;
                $food->name = $request->name;
                $food->slug = Str::slug($request->name).'-'.Str::lower(Str::random(5));
                $food->calories = $request->calories;
                $food->crabs = $request->crabs;
                $food->fat = $request->fat;
                $food->protein = $request->protein;
                $food->nutrations = $request->nutrations ? $request->nutrations : $demo_nutations;
                $food->barcode = $request->barcode;

                $uploaded_images = [];
                if($request->file('images')){
                    foreach ($request->file('images') as $image) {
                        $uploaded_images[] = uploadFile($image, 'foods');
                    }
                }


                $food->images = $uploaded_images;
                $food->save();


                return response()->json(['result' => 'true', 'message' => 'Food added successfully', 'food_id'=>$food->id]);
            } else {
                return response()->json(['result' => 'true', 'message' => 'Food added successfully', 'food_id'=>$getFood->id]);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
