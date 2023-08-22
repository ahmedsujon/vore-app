<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    // public function breakfastIndex(Request $request)
    // {
    //     try {
    //         $breakfasts = Breakfast::select('id', 'date', 'created_at')->where('user_id', api_user()->id);

    //         if ($request->filter_date) {
    //             $date = Carbon::parse($request->filter_date);
    //             $breakfasts = $breakfasts->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);
    //         }

    //         $breakfasts = $breakfasts->get();

    //         if ($breakfasts->count() > 0) {
    //             foreach ($breakfasts as $breakfast)
    //             {
    //                 $foods = [];
    //                 $breakfast_foods = BreakfastFood::select('id', 'food_id', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'serving_size')->where('breakfast_id', $breakfast->id)->get();

    //                 foreach($breakfast_foods as $food){
    //                     $foods[] = get_meals_food($food);
    //                 }

    //                 $breakfast->total_calories = $breakfast_foods->sum('calories');
    //                 $breakfast->total_protein = $breakfast_foods->sum('protein');
    //                 $breakfast->total_crabs = $breakfast_foods->sum('crabs');
    //                 $breakfast->total_fat = $breakfast_foods->sum('fat');
    //                 $breakfast->foods = $foods;
    //             }

    //             return response()->json($breakfasts);
    //         } else {
    //             return response()->json(['result' => 'false', 'message' => 'No data found!']);
    //         }
    //     } catch (Exception $ex) {
    //         return response($ex->getMessage());
    //     }
    // }

    // public function addActivity(Request $request)
    // {
    //     $rules = [
    //         'food_id' => 'required',
    //         'calories' => 'required',
    //         'protein' => 'required',
    //         'crabs' => 'required',
    //         'fat' => 'required',
    //         'quantity' => 'required',
    //         'serving_size' => 'required',
    //         'date' => 'required',
    //     ];
    //     $validator = Validator::make($request->all(), $rules);
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 400);
    //     }

    //     try {
    //         $getBreakfast = Breakfast::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
    //         if (!$getBreakfast) {
    //             $breakfast = new Breakfast();
    //             $breakfast->user_id = api_user()->id;
    //             $breakfast->date = $request->date;
    //             $breakfast->status = 1;
    //             $breakfast->save();
    //         } else {
    //             $breakfast = $getBreakfast;
    //         }

    //         $getFood = BreakfastFood::where('breakfast_id', $breakfast->id)->where('food_id', $request->food_id)->first();
    //         if(!$getFood){
    //             $food = new BreakfastFood();
    //             $food->breakfast_id = $breakfast->id;
    //             $food->food_id = $request->food_id;
    //             $food->calories = $request->calories;
    //             $food->protein = $request->protein;
    //             $food->crabs = $request->crabs;
    //             $food->fat = $request->fat;
    //             $food->quantity = $request->quantity;
    //             $food->serving_size = $request->serving_size;
    //             $food->save();
    //         } else {
    //             return response()->json(['result' => 'false', 'message' => 'Food already added']);
    //         }

    //         return response()->json(['result' => 'true', 'message' => 'Breakfast added successfully']);

    //     } catch (Exception $ex) {
    //         return response($ex->getMessage());
    //     }
    // }

    // public function getBreakfast(Request $request)
    // {
    //     try {
    //         $breakfast = Breakfast::select('id', 'date', 'created_at')->where('id', $request->breakfast_id)->where('user_id', api_user()->id)->first();

    //         if ($breakfast) {
    //             $foods = [];
    //             $breakfast_foods = BreakfastFood::select('id', 'food_id', 'calories', 'protein', 'crabs', 'fat', 'quantity', 'serving_size')->where('breakfast_id', $breakfast->id)->get();

    //             foreach($breakfast_foods as $food){
    //                 $foods[] = get_meals_food($food);
    //             }

    //             $breakfast->total_calories = $breakfast_foods->sum('calories');
    //             $breakfast->total_protein = $breakfast_foods->sum('protein');
    //             $breakfast->total_crabs = $breakfast_foods->sum('crabs');
    //             $breakfast->total_fat = $breakfast_foods->sum('fat');
    //             $breakfast->foods = $foods;

    //             return response()->json($breakfast);
    //         } else {
    //             return response()->json(['result' => 'false', 'message' => 'No data found!']);
    //         }
    //     } catch (Exception $ex) {
    //         return response($ex->getMessage());
    //     }
    // }
}