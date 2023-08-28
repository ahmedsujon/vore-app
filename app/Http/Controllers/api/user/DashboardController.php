<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Carbon\Carbon;
use App\Models\Lunch;
use App\Models\Water;
use App\Models\Dinner;
use App\Models\Snacks;
use App\Models\Breakfast;
use Illuminate\Http\Request;
use App\Models\BreakfastFood;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\UserActivityItem;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $date = Carbon::parse($request->filter_date);

            $breakfasts = Breakfast::join('breakfast_foods', 'breakfast_foods.breakfast_id', 'breakfasts.id')->where('breakfasts.user_id', api_user()->id)->select('breakfasts.id as breakfast_id', 'breakfasts.date as date',  'breakfast_foods.calories as calories', 'breakfast_foods.crabs as crabs', 'breakfast_foods.protein as protein', 'breakfast_foods.fat as fat', 'breakfast_foods.food_id as food_id')->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->get();

            $lunches = Lunch::join('lunch_foods', 'lunch_foods.lunch_id', 'lunches.id')->where('lunches.user_id', api_user()->id)->select('lunches.id as lunch_id', 'lunches.date as date',  'lunch_foods.calories as calories', 'lunch_foods.crabs as crabs', 'lunch_foods.protein as protein', 'lunch_foods.fat as fat', 'lunch_foods.food_id as food_id')->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->get();

            $snacks = Snacks::join('snack_foods', 'snack_foods.snack_id', 'snacks.id')->where('snacks.user_id', api_user()->id)->select('snacks.id as snack_id', 'snacks.date as date',  'snack_foods.calories as calories', 'snack_foods.crabs as crabs', 'snack_foods.protein as protein', 'snack_foods.fat as fat', 'snack_foods.food_id as food_id')->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->get();

            $dinners = Dinner::join('dinner_foods', 'dinner_foods.dinner_id', 'dinners.id')->where('dinners.user_id', api_user()->id)->select('dinners.id as dinner_id', 'dinners.date as date',  'dinner_foods.calories as calories', 'dinner_foods.crabs as crabs', 'dinner_foods.protein as protein', 'dinner_foods.fat as fat', 'dinner_foods.food_id as food_id')->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->get();

            //Over View
            $total_calories = api_user()->calories;
            $total_crabs = api_user()->crabs;
            $total_protein = api_user()->protein;
            $total_fat = api_user()->fat;

            $calories_eaten = $breakfasts->sum('calories') + $lunches->sum('calories') + $snacks->sum('calories') + $dinners->sum('calories');
            $calories_burned = 0;
            $crabs = $breakfasts->sum('crabs') + $lunches->sum('crabs') + $snacks->sum('crabs') + $dinners->sum('crabs');
            $protein = $breakfasts->sum('protein') + $lunches->sum('protein') + $snacks->sum('protein') + $dinners->sum('protein');
            $fat = $breakfasts->sum('fat') + $lunches->sum('fat') + $snacks->sum('fat') + $dinners->sum('fat');

            //Meals

            //breakfast
            $breakfast_id = '';
            $breakfast_foods = [];

            foreach($breakfasts as $bFast){
                $breakfast_foods[] = get_dashboard_meals_food($bFast->food_id);
                $breakfast_id = $bFast->breakfast_id;
            }
            //lunch
            $lunch_id = '';
            $lunch_foods = [];

            foreach($lunches as $lun){
                $lunch_foods[] = get_dashboard_meals_food($lun->food_id);
                $lunch_id = $lun->lunch_id;
            }
            //Snacks
            $snack_id = '';
            $snack_foods = [];

            foreach($snacks as $snc){
                $snack_foods[] = get_dashboard_meals_food($snc->food_id);
                $snack_id = $snc->snack_id;
            }
            //Dinner
            $dinner_id = '';
            $dinner_foods = [];

            foreach($dinners as $dinr){
                $dinner_foods[] = get_dashboard_meals_food($dinr->food_id);
                $dinner_id = $dinr->dinner_id;
            }


            //exercise
            $all_exercises = UserActivityItem::join('user_activities', 'user_activity_items.user_activity_id', 'user_activities.id' )
                ->select('user_activities.date as date', 'user_activity_items.*')
                ->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->where('user_activities.user_id', api_user()->id)->get();

            $exercises = [];
            foreach($all_exercises as $ex){
                $exercises[] = [
                    'id' => $ex->id,
                    'name' => Activity::find($ex->activity_id)->name,
                    'calories' => $ex->calories,
                ];
            }

            //Water
            $water = Water::whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->where('user_id', api_user()->id)->first();

            $calories_left = $total_calories - $calories_eaten;

            return response()->json([
                'target_calories' => $total_calories,
                'target_crabs' => $total_crabs,
                'target_protein' => $total_protein,
                'target_fat' => $total_fat,

                'calories_left' => $calories_left >= 0 ? $calories_left : 0,
                'calories_eaten' => $calories_eaten,
                'calories_burned' => $calories_burned,

                'crabs' => $crabs,
                'protein' => $protein,
                'fat' => $fat,

                'meals' => [
                    'breakfast' => [
                        'id' => $breakfast_id,
                        'calories' => $breakfasts->sum('calories'),
                        'foods' => $breakfast_foods
                    ],
                    'lunch' => [
                        'id' => $lunch_id,
                        'calories' => $lunches->sum('calories'),
                        'foods' => $lunch_foods
                    ],
                    'snacks' => [
                        'id' => $snack_id,
                        'calories' => $snacks->sum('calories'),
                        'foods' => $snack_foods
                    ],
                    'dinner' => [
                        'id' => $dinner_id,
                        'calories' => $dinners->sum('calories'),
                        'foods' => $dinner_foods
                    ],
                ],
                'exercise' => $exercises,
                'water' => [
                    'total' => $water ? $water->drunk : 0,
                    'goal' => $water ? $water->goal : 0,
                    'glass' => $water ? ($water->drunk / $water->pot_capacity) : 0,
                ],
            ]);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function todaysGoal(Request $request)
    {
        try {
            $date = Carbon::parse($request->date);

            $breakfasts = Breakfast::join('breakfast_foods', 'breakfast_foods.breakfast_id', 'breakfasts.id')->where('breakfasts.user_id', api_user()->id)->select('breakfasts.id as breakfast_id', 'breakfasts.date as date',  'breakfast_foods.calories as calories', 'breakfast_foods.crabs as crabs', 'breakfast_foods.protein as protein', 'breakfast_foods.fat as fat', 'breakfast_foods.food_id as food_id')->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->get();

            $lunches = Lunch::join('lunch_foods', 'lunch_foods.lunch_id', 'lunches.id')->where('lunches.user_id', api_user()->id)->select('lunches.id as lunch_id', 'lunches.date as date',  'lunch_foods.calories as calories', 'lunch_foods.crabs as crabs', 'lunch_foods.protein as protein', 'lunch_foods.fat as fat', 'lunch_foods.food_id as food_id')->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->get();

            $snacks = Snacks::join('snack_foods', 'snack_foods.snack_id', 'snacks.id')->where('snacks.user_id', api_user()->id)->select('snacks.id as snack_id', 'snacks.date as date',  'snack_foods.calories as calories', 'snack_foods.crabs as crabs', 'snack_foods.protein as protein', 'snack_foods.fat as fat', 'snack_foods.food_id as food_id')->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->get();

            $dinners = Dinner::join('dinner_foods', 'dinner_foods.dinner_id', 'dinners.id')->where('dinners.user_id', api_user()->id)->select('dinners.id as dinner_id', 'dinners.date as date',  'dinner_foods.calories as calories', 'dinner_foods.crabs as crabs', 'dinner_foods.protein as protein', 'dinner_foods.fat as fat', 'dinner_foods.food_id as food_id')->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->get();

            //Total Goals
            $total_calories = api_user()->calories;
            $total_crabs = api_user()->crabs;
            $total_protein = api_user()->protein;
            $total_fat = api_user()->fat;

            $calories = $breakfasts->sum('calories') + $lunches->sum('calories') + $snacks->sum('calories') + $dinners->sum('calories');
            $crabs = $breakfasts->sum('crabs') + $lunches->sum('crabs') + $snacks->sum('crabs') + $dinners->sum('crabs');
            $protein = $breakfasts->sum('protein') + $lunches->sum('protein') + $snacks->sum('protein') + $dinners->sum('protein');
            $fat = $breakfasts->sum('fat') + $lunches->sum('fat') + $snacks->sum('fat') + $dinners->sum('fat');

            //Meal Goals

            //breakfast
            $breakfast_calories = $breakfasts->sum('calories');
            $breakfast_crabs = $breakfasts->sum('crabs');
            $breakfast_protein = $breakfasts->sum('protein');
            $breakfast_fat = $breakfasts->sum('fat');

            //lunch
            $lunch_calories = $lunches->sum('calories');
            $lunch_crabs = $lunches->sum('crabs');
            $lunch_protein = $lunches->sum('protein');
            $lunch_fat = $lunches->sum('fat');

            //snack
            $snack_calories = $snacks->sum('calories');
            $snack_crabs = $snacks->sum('crabs');
            $snack_protein = $snacks->sum('protein');
            $snack_fat = $snacks->sum('fat');

            //dinner
            $dinner_calories = $dinners->sum('calories');
            $dinner_crabs = $dinners->sum('crabs');
            $dinner_protein = $dinners->sum('protein');
            $dinner_fat = $dinners->sum('fat');


            return response()->json([
                'target_calories' => $total_calories,
                'target_crabs' => $total_crabs,
                'target_protein' => $total_protein,
                'target_fat' => $total_fat,

                'calories' => $calories,
                'crabs' => $crabs,
                'protein' => $protein,
                'fat' => $fat,

                'meals_goal' => [
                    'breakfast' => [
                        'calories' => $breakfast_calories,
                        'crabs' => $breakfast_crabs,
                        'protein' => $breakfast_protein,
                        'fat' => $breakfast_fat,
                    ],
                    'snack' => [
                        'calories' => $snack_calories,
                        'crabs' => $snack_crabs,
                        'protein' => $snack_protein,
                        'fat' => $snack_fat,
                    ],
                    'lunch' => [
                        'calories' => $lunch_calories,
                        'crabs' => $lunch_crabs,
                        'protein' => $lunch_protein,
                        'fat' => $lunch_fat,
                    ],
                    'dinner' => [
                        'calories' => $dinner_calories,
                        'crabs' => $dinner_crabs,
                        'protein' => $dinner_protein,
                        'fat' => $dinner_fat,
                    ],
                ],
                'crabs_stg' => [
                    'status' => round(($crabs / $total_crabs) * 100),
                    'goal' => 100,
                ],
                'protein_stg' => [
                    'status' => round(($protein / $total_protein) * 100),
                    'goal' => 100,
                ],
                'fat_stg' => [
                    'status' => round(($fat / $total_fat) * 100),
                    'goal' => 100,
                ],
                'Dietary Fiber' => 0,
                'Total Sugars' => 0,
                'Saturated Fat' => 0,
                'Monounsaturated Fat' => 0,
                'Polyunsaturated Fat' => 0,
                'Trans Fat' => 0,
                'Cholesterol' => 0,
                'Sodium' => 0,
                'Salt' => 0,
                'Water' => 0,
                'Alcohol' => 0,
                'Vitamin B7' => 0,
                'Vitamin C' => 0,
                'Vitamin D' => 0,
                'Vitamin E' => 0,
                'Vitamin K' => 0,
                'Calcium' => 0,
                'Iron' => 0,
                'Magnesium' => 0,
                'Potassium' => 0,
                'Zinc' => 0,
            ]);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
