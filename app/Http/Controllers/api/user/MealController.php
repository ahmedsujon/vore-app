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
    public function getBreakfast(Request $request)
    {
        try {
            $breakfast = Breakfast::where('id', $request->breakfast_id)->where('user_id', api_user()->id)->first();

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
            $getBreakfast = Breakfast::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getBreakfast) {
                $breakfast = new Breakfast();
                $breakfast->user_id = api_user()->id;
                $breakfast->foods = $request->foods;
                $breakfast->total_calories = $request->total_calories;
                $breakfast->total_protein = $request->total_protein;
                $breakfast->total_crabs = $request->total_crabs;
                $breakfast->total_fat = $request->total_fat;
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
    public function getLunch(Request $request)
    {
        try {
            $lunch = Lunch::where('id', $request->lunch_id)->where('user_id', api_user()->id)->first();

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
}
