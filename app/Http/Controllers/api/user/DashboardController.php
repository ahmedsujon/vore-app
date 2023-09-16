<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Carbon\Carbon;
use App\Models\Lunch;
use App\Models\Water;
use App\Models\Dinner;
use App\Models\Snacks;
use App\Models\Activity;
use App\Models\Breakfast;
use Illuminate\Http\Request;
use App\Models\BreakfastFood;
use App\Models\UserActivityItem;
use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\User;
use App\Models\WaterSetting;
use Illuminate\Support\Facades\Validator;

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
                $breakfast_foods[] = get_dashboard_meals_food($bFast->food_id, 'breakfast');
                $breakfast_id = $bFast->breakfast_id;
            }
            //lunch
            $lunch_id = '';
            $lunch_foods = [];

            foreach($lunches as $lun){
                $lunch_foods[] = get_dashboard_meals_food($lun->food_id, 'lunch');
                $lunch_id = $lun->lunch_id;
            }
            //Snacks
            $snack_id = '';
            $snack_foods = [];

            foreach($snacks as $snc){
                $snack_foods[] = get_dashboard_meals_food($snc->food_id, 'snacks');
                $snack_id = $snc->snack_id;
            }
            //Dinner
            $dinner_id = '';
            $dinner_foods = [];

            foreach($dinners as $dinr){
                $dinner_foods[] = get_dashboard_meals_food($dinr->food_id, 'dinner');
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
            $water = [];
            $getWater = Water::whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->where('user_id', api_user()->id)->first();
            $waterSetting = WaterSetting::where('user_id', api_user()->id)->first();

            $water = [
                'glass' => $getWater ? $getWater->glass : 0,
                'goal_glass' => round($waterSetting->goal / $waterSetting->pot_capacity),
                'drunk' => $getWater ? $getWater->drunk . ' fl oz' : '0 fl oz',
                'goal' => $waterSetting->goal . ' fl oz',
            ];

            $calories_left = $total_calories - $calories_eaten;

            return response()->json([
                'total_calories' => $total_calories,
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
                'water' => $water,
                'measurements' => $this->getMeasurement($request),
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

    private function getMeasurement($request)
    {
        try {
            $user = User::find(api_user()->id);

            $weight = $user->current_weight_unit == 'kg' ? ($user->current_weight * 2.20462) : $user->current_weight;
            $target_weight = $user->target_weight_unit == 'kg' ? ($user->target_weight * 2.20462) : $user->target_weight;

            $weight = round($weight, 1);
            $target_weight = round($target_weight, 1);

            $weight = is_numeric($weight) && floor($weight) == $weight ? $weight . '.0' : $weight;
            $target_weight = is_numeric($target_weight) && floor($target_weight) == $target_weight ? $target_weight . '.0' : $target_weight;

            $data = [
                'weight' => $weight . ' lb',
                'target_weight' => $target_weight . ' lb',
            ];

            return $data;

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function updateMeasurement(Request $request)
    {
        $rules = [
            'weight' => 'required',
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = User::find(api_user()->id);
            if ($user->current_weight_unit == 'kg') {
                $weight = round(($request->weight / 2.20462), 1);
            } else {
                $weight = $request->weight;
            }
            $user->current_weight = $weight;
            $user->save();

            $getMeasurement = Measurement::where('user_id', api_user()->id)->where('date', Carbon::parse($request->date)->format('Y-m-d'))->first();
            if($getMeasurement){
                $mes = $getMeasurement;
                $mes->weight = round(($request->weight / 2.20462), 1);
            } else {
                $mes = new Measurement();
                $mes->user_id = api_user()->id;
                $mes->date = $request->date;
                $mes->weight = round(($request->weight / 2.20462), 1);
            }
            $mes->save();

            return response()->json(['result' => 'true', 'message' => 'Data updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    //Water
    private function getWater($request)
    {
        try {
            $water = Water::select('glass', 'drunk')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            $setting = WaterSetting::where('user_id', api_user()->id)->first();

            $water->drunk = $water->drunk . ' fl oz';
            $water->goal = $setting->goal . ' fl oz';
            $water->goal_glass = round($setting->goal / $setting->pot_capacity);

            return $water;
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addWater(Request $request)
    {
        $rules = [
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $setting = WaterSetting::where('user_id', api_user()->id)->first();

            $getData = Water::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getData) {
                $water = new Water();
                $water->user_id = api_user()->id;
                $water->glass = 1;
                $water->drunk = $setting->pot_capacity;
                $water->date = Carbon::parse($request->date)->format('Y-m-d');
            } else {
                $water = $getData;
                $water->drunk += $setting->pot_capacity;
                $water->glass += 1;
            }
            $water->save();

            return response()->json(['result' => 'true', 'message' => 'Water added successfully']);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
