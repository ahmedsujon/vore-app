<?php

namespace App\Http\Controllers\api\user;

use Exception;
use App\Models\Lunch;
use App\Models\Breakfast;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BreakfastFood;
use App\Models\Dinner;
use App\Models\Snacks;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    // Breakfast
    public function breakfastIndex(Request $request)
    {
        try {
            $breakfasts = Breakfast::select('id', 'foods', 'total_calories', 'total_protein', 'total_crabs', 'total_fat', 'date', 'created_at')->where('user_id', api_user()->id);

            if ($request->filter_date) {
                $date = Carbon::parse($request->filter_date);
                $breakfasts = $breakfasts->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);
            }

            $breakfasts = $breakfasts->get();

            if ($breakfasts->count() > 0) {
                foreach ($breakfasts as $breakfast)
                {
                    $foods = [];
                    foreach($breakfast->foods as $food){
                        $foods[] = get_meals_food($food);
                    }

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

    public function getBreakfast(Request $request)
    {
        try {
            $breakfast = Breakfast::select('id', 'foods', 'total_calories', 'total_protein', 'total_crabs', 'total_fat', 'date', 'created_at')->where('id', $request->breakfast_id)->where('user_id', api_user()->id)->first();

            $foods = [];
            foreach($breakfast->foods as $food){
                $foods[] = get_meals_food($food);
            }

            $breakfast->foods = $foods;

            if ($breakfast) {
                return response()->json($breakfast);
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

            $getFood = BreakfastFood::where('breakfast_id', $breakfast->id)->where('food_id', $request->food_id)->first();
            if(!$getFood){
                $food = new BreakfastFood();
                $food->breakfast_id = $breakfast->id;
                $food->food_id = $request->food_id;
                $food->calories = $request->calories;
                $food->protein = $request->protein;
                $food->crabs = $request->crabs;
                $food->fat = $request->fat;
                $food->quantity = $request->quantity;
                $food->serving_size = $request->serving_size;
                $food->save();
            } else {
                return response()->json(['result' => 'false', 'message' => 'Food already added']);
            }

            return response()->json(['result' => 'true', 'message' => 'Breakfast added successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    // Lunch
    public function lunchIndex(Request $request)
    {
        try {
            $lunches = Lunch::select('id', 'foods', 'total_calories', 'total_protein', 'total_crabs', 'total_fat', 'date', 'created_at')->where('user_id', api_user()->id);

            if ($request->filter_date) {
                $date = Carbon::parse($request->filter_date);
                $lunches = $lunches->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);
            }

            $lunches = $lunches->get();

            if ($lunches->count() > 0) {
                foreach ($lunches as $lunch)
                {
                    $foods = [];
                    foreach($lunch->foods as $food){
                        $foods[] = get_meals_food($food);
                    }

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

    public function getLunch(Request $request)
    {
        try {
            $lunch = Lunch::select('id', 'foods', 'total_calories', 'total_protein', 'total_crabs', 'total_fat', 'date', 'created_at')->where('id', $request->lunch_id)->where('user_id', api_user()->id)->first();

            $foods = [];
            foreach($lunch->foods as $food){
                $foods[] = get_meals_food($food);
            }

            $lunch->foods = $foods;

            if ($lunch) {
                return response()->json($lunch);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addlunch(Request $request)
    {
        $rules = [
            'foods' => 'required',
            'total_calories' => 'required',
            'total_protein' => 'required',
            'total_crabs' => 'required',
            'total_fat' => 'required',
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
                $lunch->foods = $request->foods;
                $lunch->total_calories = $request->total_calories;
                $lunch->total_protein = $request->total_protein;
                $lunch->total_crabs = $request->total_crabs;
                $lunch->total_fat = $request->total_fat;
                $lunch->date = $request->date;
                $lunch->status = 1;
                $lunch->save();

                return response()->json(['result' => 'true', 'message' => 'Lunch added successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'Lunch already added for this date']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    // Snacks
    public function snackIndex(Request $request)
    {
        try {
            $snacks = Snacks::select('id', 'foods', 'total_calories', 'total_protein', 'total_crabs', 'total_fat', 'date', 'created_at')->where('user_id', api_user()->id);

            if ($request->filter_date) {
                $date = Carbon::parse($request->filter_date);
                $snacks = $snacks->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);
            }

            $snacks = $snacks->get();

            if ($snacks->count() > 0) {
                foreach ($snacks as $snack)
                {
                    $foods = [];
                    foreach($snack->foods as $food){
                        $foods[] = get_meals_food($food);
                    }

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

    public function getSnack(Request $request)
    {
        try {
            $snack = Snacks::select('id', 'foods', 'total_calories', 'total_protein', 'total_crabs', 'total_fat', 'date', 'created_at')->where('id', $request->snack_id)->where('user_id', api_user()->id)->first();

            $foods = [];
            foreach($snack->foods as $food){
                $foods[] = get_meals_food($food);
            }

            $snack->foods = $foods;

            if ($snack) {
                return response()->json($snack);
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
            'foods' => 'required',
            'total_calories' => 'required',
            'total_protein' => 'required',
            'total_crabs' => 'required',
            'total_fat' => 'required',
            'date' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getSnacks = Snacks::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getSnacks) {
                $snack = new Snacks();
                $snack->user_id = api_user()->id;
                $snack->foods = $request->foods;
                $snack->total_calories = $request->total_calories;
                $snack->total_protein = $request->total_protein;
                $snack->total_crabs = $request->total_crabs;
                $snack->total_fat = $request->total_fat;
                $snack->date = $request->date;
                $snack->status = 1;
                $snack->save();

                return response()->json(['result' => 'true', 'message' => 'Snack added successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'Snack already added for this date']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    // Dinners
    public function dinnerIndex(Request $request)
    {
        try {
            $dinners = Dinner::select('id', 'foods', 'total_calories', 'total_protein', 'total_crabs', 'total_fat', 'date', 'created_at')->where('user_id', api_user()->id);

            if ($request->filter_date) {
                $date = Carbon::parse($request->filter_date);
                $dinners = $dinners->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);
            }

            $dinners = $dinners->get();

            if ($dinners->count() > 0) {
                foreach ($dinners as $dinner)
                {
                    $foods = [];
                    foreach($dinner->foods as $food){
                        $foods[] = get_meals_food($food);
                    }

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

    public function getDinner(Request $request)
    {
        try {
            $dinner = Dinner::select('id', 'foods', 'total_calories', 'total_protein', 'total_crabs', 'total_fat', 'date', 'created_at')->where('id', $request->dinner_id)->where('user_id', api_user()->id)->first();

            $foods = [];
            foreach($dinner->foods as $food){
                $foods[] = get_meals_food($food);
            }

            $dinner->foods = $foods;

            if ($dinner) {
                return response()->json($dinner);
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
            'foods' => 'required',
            'total_calories' => 'required',
            'total_protein' => 'required',
            'total_crabs' => 'required',
            'total_fat' => 'required',
            'date' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getDinners = Dinner::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getDinners) {
                $dinner = new Dinner();
                $dinner->user_id = api_user()->id;
                $dinner->foods = $request->foods;
                $dinner->total_calories = $request->total_calories;
                $dinner->total_protein = $request->total_protein;
                $dinner->total_crabs = $request->total_crabs;
                $dinner->total_fat = $request->total_fat;
                $dinner->date = $request->date;
                $dinner->status = 1;
                $dinner->save();

                return response()->json(['result' => 'true', 'message' => 'Dinner added successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'Dinner already added for this date']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
