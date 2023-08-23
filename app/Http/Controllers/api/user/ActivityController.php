<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Carbon\Carbon;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\UserActivityItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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

    public function addUserActivity(Request $request)
    {
        $rules = [
            'activity_id' => 'required',
            'calories' => 'required',
            'duration' => 'required',
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getUserActivity = UserActivity::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getUserActivity) {
                $user_activity = new UserActivity();
                $user_activity->user_id = api_user()->id;
                $user_activity->date = $request->date;
                $user_activity->status = 1;
                $user_activity->save();
            } else {
                $user_activity = $getUserActivity;
            }

            $act_item = new UserActivityItem();
            $act_item->user_activity_id = $user_activity->id;
            $act_item->activity_id = $request->activity_id;
            $act_item->calories = $request->calories;
            $act_item->duration = $request->duration;
            $act_item->save();

            return response()->json(['result' => 'true', 'message' => 'Activity added successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

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
