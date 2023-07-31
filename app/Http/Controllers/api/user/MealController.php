<?php

namespace App\Http\Controllers\api\user;

use Exception;
use App\Models\Breakfast;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    public function breakfastIndex(Request $request)
    {

        return response()->json('data');
    }

    public function addBreakfast(Request $request)
    {
        $rules = [
            'foods' => 'required',
            'total_calories' => 'required',
            'total_protein' => 'required',
            'total_crabs' => 'required',
            'total_fat' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $breakfast = new Breakfast();
            $breakfast->foods = $request->foods;
            $breakfast->total_calories = $request->total_calories;
            $breakfast->total_protein = $request->total_protein;
            $breakfast->total_crabs = $request->total_crabs;
            $breakfast->total_fat = $request->total_fat;
            $breakfast->status = 1;
            $breakfast->save();

            return response()->json(['result'=>'true', 'message' => 'Breakfast added successfully']);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
