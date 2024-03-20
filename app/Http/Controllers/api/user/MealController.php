<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\Breakfast;
use App\Models\BreakfastFood;
use App\Models\Dinner;
use App\Models\DinnerFood;
use App\Models\Food;
use App\Models\Lunch;
use App\Models\LunchFood;
use App\Models\SnackFood;
use App\Models\Snacks;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    // Breakfast
    public function breakfastIndex(Request $request)
    {
        try {
            $breakfasts = Breakfast::select('id', 'date', 'created_at')->where('user_id', api_user()->id);

            if ($request->filter_date) {
                $date = Carbon::parse($request->filter_date);
                $breakfasts = $breakfasts->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);
            }

            $breakfasts = $breakfasts->get();

            if ($breakfasts->count() > 0) {
                foreach ($breakfasts as $breakfast) {
                    $foods = [];
                    $breakfast_foods = BreakfastFood::select('id', 'food_id', 'name', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'image', 'serving_size', 'nutations')->where('breakfast_id', $breakfast->id)->get();

                    foreach ($breakfast_foods as $food) {
                        $foods[] = get_meals_food($food, 'breakfast');
                    }

                    $breakfast->total_calories = $breakfast_foods->sum('calories');
                    $breakfast->total_protein = $breakfast_foods->sum('protein');
                    $breakfast->total_crabs = $breakfast_foods->sum('crabs');
                    $breakfast->total_fat = $breakfast_foods->sum('fat');
                    $breakfast->foods = $foods;
                }

                return response()->json($breakfasts);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addBreakfast(Request $request)
    {
        $rules = [
            'food_id' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
            'quantity' => 'required',
            'serving_size' => 'required',
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getBreakfast = Breakfast::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getBreakfast) {
                $breakfast = new Breakfast();
                $breakfast->user_id = api_user()->id;
                $breakfast->date = $request->date;
                $breakfast->status = 1;
                $breakfast->save();
            } else {
                $breakfast = $getBreakfast;
            }

            $food = new BreakfastFood();
            $food->breakfast_id = $breakfast->id;
            $food->food_id = $request->food_id;
            $food->name = Food::find($request->food_id)->name;
            $food->calories = $request->calories;
            $food->protein = $request->protein;
            $food->crabs = $request->crabs;
            $food->fat = $request->fat;
            $food->quantity = $request->quantity;
            $food->serving_size = $request->serving_size;
            $food->image = '';
            $food->nutations = Food::find($request->food_id)->nutrations;
            $food->save();

            return response()->json(['result' => 'true', 'message' => 'Breakfast added successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function getBreakfast(Request $request)
    {
        try {
            $breakfast = Breakfast::select('id', 'date', 'created_at')->where('id', $request->breakfast_id)->where('user_id', api_user()->id)->first();

            if ($breakfast) {
                $foods = [];
                $breakfast_foods = BreakfastFood::select('id', 'food_id', 'name', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'image', 'serving_size', 'nutations')->where('breakfast_id', $breakfast->id)->get();

                foreach ($breakfast_foods as $food) {
                    $foods[] = get_meals_food($food, 'breakfast');
                }

                $breakfast->total_calories = $breakfast_foods->sum('calories');
                $breakfast->total_protein = $breakfast_foods->sum('protein');
                $breakfast->total_crabs = $breakfast_foods->sum('crabs');
                $breakfast->total_fat = $breakfast_foods->sum('fat');
                $breakfast->foods = $foods;

                return response()->json($breakfast);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function updateBreakfast(Request $request)
    {
        $rules = [
            'breakfast_id' => 'required',
            'food_id' => 'required',
            'name' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
            'quantity' => 'required',
            'serving_size' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $food = BreakfastFood::find($request->food_id);
            $food->name = $request->name;
            $food->calories = $request->calories;
            $food->protein = $request->protein;
            $food->crabs = $request->crabs;
            $food->fat = $request->fat;
            $food->quantity = $request->quantity;
            $food->serving_size = $request->serving_size;
            if ($request->file('new_image')) {
                $food->image = uploadFile($request->file('new_image'), 'foods');
            }
            if ($request->get('nutations')) {
                $food->nutations = $request->get('nutations');
            }
            $food->save();

            return response()->json(['result' => 'true', 'message' => 'Breakfast updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function deleteBreakfast(Request $request)
    {
        try {
            $item = BreakfastFood::where('id', $request->item_id)->first();

            if ($item) {
                $item->delete();
                return response()->json(['result' => 'true', 'message' => 'Item deleted successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    // Lunch
    public function lunchIndex(Request $request)
    {
        try {
            $lunches = Lunch::select('id', 'date', 'created_at')->where('user_id', api_user()->id);

            if ($request->filter_date) {
                $date = Carbon::parse($request->filter_date);
                $lunches = $lunches->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);
            }

            $lunches = $lunches->get();

            if ($lunches->count() > 0) {
                foreach ($lunches as $lunch) {
                    $foods = [];
                    $lunch_foods = LunchFood::select('id', 'food_id', 'name', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'image', 'serving_size', 'nutations')->where('lunch_id', $lunch->id)->get();

                    foreach ($lunch_foods as $food) {
                        $foods[] = get_meals_food($food, 'lunch');
                    }

                    $lunch->total_calories = $lunch_foods->sum('calories');
                    $lunch->total_protein = $lunch_foods->sum('protein');
                    $lunch->total_crabs = $lunch_foods->sum('crabs');
                    $lunch->total_fat = $lunch_foods->sum('fat');
                    $lunch->foods = $foods;
                }

                return response()->json($lunches);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addLunch(Request $request)
    {
        $rules = [
            'food_id' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
            'quantity' => 'required',
            'serving_size' => 'required',
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getLunch = Lunch::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getLunch) {
                $lunch = new Lunch();
                $lunch->user_id = api_user()->id;
                $lunch->date = $request->date;
                $lunch->status = 1;
                $lunch->save();
            } else {
                $lunch = $getLunch;
            }
            $food = new LunchFood();
            $food->lunch_id = $lunch->id;
            $food->food_id = $request->food_id;
            $food->name = Food::find($request->food_id)->name;
            $food->calories = $request->calories;
            $food->protein = $request->protein;
            $food->crabs = $request->crabs;
            $food->fat = $request->fat;
            $food->quantity = $request->quantity;
            $food->serving_size = $request->serving_size;
            $food->image = '';
            $food->nutations = Food::find($request->food_id)->nutrations;
            $food->save();

            return response()->json(['result' => 'true', 'message' => 'Lunch added successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function updateLunch(Request $request)
    {
        $rules = [
            'lunch_id' => 'required',
            'food_id' => 'required',
            'name' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
            'quantity' => 'required',
            'serving_size' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $food = LunchFood::find($request->food_id);
            $food->name = $request->name;
            $food->calories = $request->calories;
            $food->protein = $request->protein;
            $food->crabs = $request->crabs;
            $food->fat = $request->fat;
            $food->quantity = $request->quantity;
            $food->serving_size = $request->serving_size;
            if ($request->file('new_image')) {
                $food->image = uploadFile($request->file('new_image'), 'foods');
            }
            if ($request->get('nutations')) {
                $food->nutations = $request->get('nutations');
            }
            $food->save();

            return response()->json(['result' => 'true', 'message' => 'Lunch updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function getLunch(Request $request)
    {
        try {
            $lunch = Lunch::select('id', 'date', 'created_at')->where('id', $request->lunch_id)->where('user_id', api_user()->id)->first();

            if ($lunch) {
                $foods = [];
                $lunch_foods = LunchFood::select('id', 'food_id', 'name', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'image', 'serving_size', 'nutations')->where('lunch_id', $lunch->id)->get();

                foreach ($lunch_foods as $food) {
                    $foods[] = get_meals_food($food, 'lunch');
                }

                $lunch->total_calories = $lunch_foods->sum('calories');
                $lunch->total_protein = $lunch_foods->sum('protein');
                $lunch->total_crabs = $lunch_foods->sum('crabs');
                $lunch->total_fat = $lunch_foods->sum('fat');
                $lunch->foods = $foods;

                return response()->json($lunch);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function deleteLunch(Request $request)
    {
        try {
            $item = LunchFood::where('id', $request->item_id)->first();

            if ($item) {
                $item->delete();
                return response()->json(['result' => 'true', 'message' => 'Item deleted successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    // Snacks
    public function snackIndex(Request $request)
    {
        try {
            $snacks = Snacks::select('id', 'date', 'created_at')->where('user_id', api_user()->id);

            if ($request->filter_date) {
                $date = Carbon::parse($request->filter_date);
                $snacks = $snacks->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);
            }

            $snacks = $snacks->get();

            if ($snacks->count() > 0) {
                foreach ($snacks as $snack) {
                    $foods = [];
                    $snack_foods = SnackFood::select('id', 'food_id', 'name', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'image', 'serving_size', 'nutations')->where('snack_id', $snack->id)->get();

                    foreach ($snack_foods as $food) {
                        $foods[] = get_meals_food($food, 'snacks');
                    }

                    $snack->total_calories = $snack_foods->sum('calories');
                    $snack->total_protein = $snack_foods->sum('protein');
                    $snack->total_crabs = $snack_foods->sum('crabs');
                    $snack->total_fat = $snack_foods->sum('fat');
                    $snack->foods = $foods;
                }

                return response()->json($snacks);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addSnack(Request $request)
    {
        $rules = [
            'food_id' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
            'quantity' => 'required',
            'serving_size' => 'required',
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getSnack = Snacks::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getSnack) {
                $snack = new Snacks();
                $snack->user_id = api_user()->id;
                $snack->date = $request->date;
                $snack->status = 1;
                $snack->save();
            } else {
                $snack = $getSnack;
            }

            $food = new SnackFood();
            $food->snack_id = $snack->id;
            $food->food_id = $request->food_id;
            $food->name = Food::find($request->food_id)->name;
            $food->calories = $request->calories;
            $food->protein = $request->protein;
            $food->crabs = $request->crabs;
            $food->fat = $request->fat;
            $food->quantity = $request->quantity;
            $food->serving_size = $request->serving_size;
            $food->image = '';
            $food->nutations = Food::find($request->food_id)->nutrations;
            $food->save();

            return response()->json(['result' => 'true', 'message' => 'Snacks added successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function getSnack(Request $request)
    {
        try {
            $snack = Snacks::select('id', 'date', 'created_at')->where('id', $request->snack_id)->where('user_id', api_user()->id)->first();

            if ($snack) {
                $foods = [];
                $snack_foods = SnackFood::select('id', 'food_id', 'name', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'image', 'serving_size', 'nutations')->where('snack_id', $snack->id)->get();

                foreach ($snack_foods as $food) {
                    $foods[] = get_meals_food($food, 'snacks');
                }

                $snack->total_calories = $snack_foods->sum('calories');
                $snack->total_protein = $snack_foods->sum('protein');
                $snack->total_crabs = $snack_foods->sum('crabs');
                $snack->total_fat = $snack_foods->sum('fat');
                $snack->foods = $foods;

                return response()->json($snack);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function updateSnack(Request $request)
    {
        $rules = [
            'snack_id' => 'required',
            'food_id' => 'required',
            'name' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
            'quantity' => 'required',
            'serving_size' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $food = SnackFood::find($request->food_id);
            $food->name = $request->name;
            $food->calories = $request->calories;
            $food->protein = $request->protein;
            $food->crabs = $request->crabs;
            $food->fat = $request->fat;
            $food->quantity = $request->quantity;
            $food->serving_size = $request->serving_size;
            if ($request->file('new_image')) {
                $food->image = uploadFile($request->file('new_image'), 'foods');
            }
            if ($request->get('nutations')) {
                $food->nutations = $request->get('nutations');
            }
            $food->save();

            return response()->json(['result' => 'true', 'message' => 'Snack updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function deleteSnack(Request $request)
    {
        try {
            $item = SnackFood::where('id', $request->item_id)->first();

            if ($item) {
                $item->delete();
                return response()->json(['result' => 'true', 'message' => 'Item deleted successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    // Dinners
    public function dinnerIndex(Request $request)
    {
        try {
            $dinners = Dinner::select('id', 'date', 'created_at')->where('user_id', api_user()->id);

            if ($request->filter_date) {
                $date = Carbon::parse($request->filter_date);
                $dinners = $dinners->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);
            }

            $dinners = $dinners->get();

            if ($dinners->count() > 0) {
                foreach ($dinners as $dinner) {
                    $foods = [];
                    $dinner_foods = DinnerFood::select('id', 'food_id', 'name', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'image', 'serving_size', 'nutations')->where('dinner_id', $dinner->id)->get();

                    foreach ($dinner_foods as $food) {
                        $foods[] = get_meals_food($food, 'dinner');
                    }

                    $dinner->total_calories = $dinner_foods->sum('calories');
                    $dinner->total_protein = $dinner_foods->sum('protein');
                    $dinner->total_crabs = $dinner_foods->sum('crabs');
                    $dinner->total_fat = $dinner_foods->sum('fat');
                    $dinner->foods = $foods;
                }

                return response()->json($dinners);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addDinner(Request $request)
    {
        $rules = [
            'food_id' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
            'quantity' => 'required',
            'serving_size' => 'required',
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getdinner = Dinner::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getdinner) {
                $dinner = new Dinner();
                $dinner->user_id = api_user()->id;
                $dinner->date = $request->date;
                $dinner->status = 1;
                $dinner->save();
            } else {
                $dinner = $getdinner;
            }

            $food = new DinnerFood();
            $food->dinner_id = $dinner->id;
            $food->food_id = $request->food_id;
            $food->name = Food::find($request->food_id)->name;
            $food->calories = $request->calories;
            $food->protein = $request->protein;
            $food->crabs = $request->crabs;
            $food->fat = $request->fat;
            $food->quantity = $request->quantity;
            $food->serving_size = $request->serving_size;
            $food->image = '';
            $food->nutations = Food::find($request->food_id)->nutrations;
            $food->save();

            return response()->json(['result' => 'true', 'message' => 'Dinner added successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function getDinner(Request $request)
    {
        try {
            $dinner = Dinner::select('id', 'date', 'created_at')->where('id', $request->dinner_id)->where('user_id', api_user()->id)->first();

            if ($dinner) {
                $foods = [];
                $dinner_foods = DinnerFood::select('id', 'food_id', 'name', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'image', 'serving_size', 'nutations')->where('dinner_id', $dinner->id)->get();

                foreach ($dinner_foods as $food) {
                    $foods[] = get_meals_food($food, 'dinner');
                }

                $dinner->total_calories = $dinner_foods->sum('calories');
                $dinner->total_protein = $dinner_foods->sum('protein');
                $dinner->total_crabs = $dinner_foods->sum('crabs');
                $dinner->total_fat = $dinner_foods->sum('fat');
                $dinner->foods = $foods;

                return response()->json($dinner);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function updateDinner(Request $request)
    {
        $rules = [
            'dinner_id' => 'required',
            'food_id' => 'required',
            'name' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
            'quantity' => 'required',
            'serving_size' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $food = DinnerFood::find($request->food_id);
            $food->name = $request->name;
            $food->calories = $request->calories;
            $food->protein = $request->protein;
            $food->crabs = $request->crabs;
            $food->fat = $request->fat;
            $food->quantity = $request->quantity;
            $food->serving_size = $request->serving_size;
            if ($request->file('new_image')) {
                $food->image = uploadFile($request->file('new_image'), 'foods');
            }
            if ($request->get('nutations')) {
                $food->nutations = $request->get('nutations');
            }
            $food->save();

            return response()->json(['result' => 'true', 'message' => 'Dinner updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function deleteDinner(Request $request)
    {
        try {
            $item = DinnerFood::where('id', $request->item_id)->first();

            if ($item) {
                $item->delete();
                return response()->json(['result' => 'true', 'message' => 'Item deleted successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
