<?php

namespace App\Http\Controllers\api\user;

use Exception;
use App\Models\Lunch;
use App\Models\Breakfast;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    // Breakfast
    public function breakfastIndex(Request $request)
    {
        try {
            $breakfasts = Breakfast::select('id', 'foods', 'calories', 'protein', 'crabs', 'fat', 'date', 'created_at')->where('user_id', api_user()->id);

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
            $breakfast = Breakfast::select('id', 'foods', 'calories', 'protein', 'crabs', 'fat', 'date', 'created_at')->where('id', $request->breakfast_id)->where('user_id', api_user()->id)->first();

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
            'foods' => 'required',
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
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
                $breakfast->food = $request->food;
                $breakfast->calories = $request->calories;
                $breakfast->protein = $request->protein;
                $breakfast->crabs = $request->crabs;
                $breakfast->fat = $request->fat;
                $breakfast->date = $request->date;
                $breakfast->status = 1;
                $breakfast->save();

                return response()->json(['result' => 'true', 'message' => 'Breakfast added successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'Breakfast already added for this date']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    // Lunch
    public function lunchIndex(Request $request)
    {
        try {
            $lunches = Lunch::select('id', 'foods', 'calories', 'protein', 'crabs', 'fat', 'date', 'created_at')->where('user_id', api_user()->id);

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
            $lunch = Lunch::select('id', 'foods', 'calories', 'protein', 'crabs', 'fat', 'date', 'created_at')->where('id', $request->lunch_id)->where('user_id', api_user()->id)->first();

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
            'calories' => 'required',
            'protein' => 'required',
            'crabs' => 'required',
            'fat' => 'required',
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
                $lunch->calories = $request->calories;
                $lunch->protein = $request->protein;
                $lunch->crabs = $request->crabs;
                $lunch->fat = $request->fat;
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
}
