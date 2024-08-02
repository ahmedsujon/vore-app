<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\UserFavoriteFood;
use App\Models\UserRecentFood;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    public function getFoods(Request $request)
    {
        // $pagination_value = $request->per_page ? $request->per_page : 10;
        $foods = Food::select('id', 'name', 'slug', 'calories', 'protein', 'crabs', 'fat', 'nutrations', 'barcode', 'images', 'created_at')->where('name', 'like', '%' . $request->search_term . '%')->where('status', 1)->get();

        foreach ($foods as $food) {
            $imgs = [];
            if ($food->is_fat_secret == 1) {
                if ($food->api_image) {
                    $imgs[] = $food->api_image;
                } else {
                    $imgs[] = '';
                }
            } else {
                if (count($food->images) > 0) {
                    foreach ($food->images as $image) {
                        $imgs[] = url('/') . '/' . $image;
                    }
                } else {
                    $imgs[] = '';
                }
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
                "zinc" => 0,
            ];

            if (!$getFood) {
                $food = new Food();
                $food->added_by = 'user';
                $food->food_unique_id = $request->food_unique_id ? $request->food_unique_id : 'vore_food_' . Str::lower(Str::random(15));
                $food->user_id = api_user()->id;
                $food->name = $request->name;
                $food->slug = Str::slug($request->name) . '-' . Str::lower(Str::random(5));
                $food->calories = $request->calories;
                $food->crabs = $request->crabs;
                $food->fat = $request->fat;
                $food->protein = $request->protein;
                $food->nutrations = $request->nutrations ? $request->nutrations : $demo_nutations;
                $food->barcode = $request->barcode;
                $food->is_fat_secret = $request->food_unique_id ? 1 : 0;

                $uploaded_images = [];
                if ($request->file('images')) {
                    foreach ($request->file('images') as $image) {
                        $uploaded_images[] = uploadFile($image, 'foods');
                    }
                }

                $food->images = $uploaded_images;
                $food->api_image = $request->api_image;
                $food->save();

                add_to_recent_food(api_user()->id, $food->id);
                return response()->json(['result' => 'true', 'message' => 'Food added successfully', 'food_id' => $food->id]);
            } else {
                add_to_recent_food(api_user()->id, $getFood->id);
                return response()->json(['result' => 'true', 'message' => 'Food added successfully', 'food_id' => $getFood->id]);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function recentFoods(Request $request)
    {
        $pagination_value = $request->per_page ? $request->per_page : 10;

        $foods = Food::select('foods.id', 'foods.food_unique_id', 'foods.name', 'foods.slug', 'foods.calories', 'foods.protein', 'foods.crabs', 'foods.fat', 'foods.nutrations', 'foods.barcode', 'foods.images', 'foods.api_image', 'foods.is_fat_secret', 'foods.user_id', 'foods.created_at')
        ->join('user_recent_foods', 'user_recent_foods.food_id', 'foods.id')
        ->where('foods.name', 'like', '%' . $request->search_term . '%')
        ->where('user_recent_foods.user_id', api_user()->id)
        ->whereBetween('user_recent_foods.updated_at', [now()->subDays(7), now()])
        ->orderBy('user_recent_foods.updated_at', 'DESC')
        ->paginate($pagination_value);

        foreach ($foods as $food) {
            $imgs = [];
            if (count($food->images) > 0) {
                foreach ($food->images as $image) {
                    $imgs[] = url('/') . '/' . $image;
                }
            }
            $food->images = $imgs;
        }

        return response()->json($foods);
    }

    public function favoriteFoods(Request $request)
    {
        $pagination_value = $request->per_page ? $request->per_page : 10;

        $foods = Food::select('foods.id', 'foods.food_unique_id', 'foods.name', 'foods.slug', 'foods.calories', 'foods.protein', 'foods.crabs', 'foods.fat', 'foods.nutrations', 'foods.barcode', 'foods.images', 'foods.api_image', 'foods.is_fat_secret', 'foods.user_id', 'foods.created_at')
        ->join('user_favorite_foods', 'user_favorite_foods.food_id', 'foods.id')
        ->where('foods.name', 'like', '%' . $request->search_term . '%')
        ->where('user_favorite_foods.user_id', api_user()->id)
        ->orderBy('user_favorite_foods.created_at', 'DESC')
        ->paginate($pagination_value);

        foreach ($foods as $food) {
            $imgs = [];
            if (count($food->images) > 0) {
                foreach ($food->images as $image) {
                    $imgs[] = url('/') . '/' . $image;
                }
            }
            $food->images = $imgs;
        }

        return response()->json($foods);
    }

    public function addRemoveFavorite(Request $request)
    {
        $rules = [
            'food_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getData = UserFavoriteFood::where('food_id', $request->food_id)->where('user_id', api_user()->id)->first();

            if ($getData) {
                $getData->delete();
                return response()->json(['result' => true, 'message' => 'Food removed from favorites']);
            } else {
                $fav = new UserFavoriteFood();
                $fav->user_id = api_user()->id;
                $fav->food_id = $request->food_id;
                $fav->save();
                return response()->json(['result' => true, 'message' => 'Food added to favorites']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
