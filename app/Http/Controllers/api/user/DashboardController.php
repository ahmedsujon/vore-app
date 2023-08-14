<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Breakfast;
use App\Models\BreakfastFood;
use App\Models\Dinner;
use App\Models\Lunch;
use App\Models\Snacks;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $breakfasts = Breakfast::join('breakfast_foods', 'breakfast_foods.breakfast_id', 'breakfasts.id')->where('breakfasts.user_id', api_user()->id)->select('breakfasts.id as breakfast_id', 'breakfast_foods.calories as calories', 'breakfast_foods.crabs as crabs', 'breakfast_foods.protein as protein', 'breakfast_foods.fat as fat', 'breakfast_foods.food_id as food_id');

            $lunches = Lunch::join('lunch_foods', 'lunch_foods.lunch_id', 'lunches.id')->where('lunches.user_id', api_user()->id)->select('lunch_foods.calories as calories', 'lunch_foods.crabs as crabs', 'lunch_foods.protein as protein', 'lunch_foods.fat as fat');

            $snacks = Snacks::join('snack_foods', 'snack_foods.snack_id', 'snacks.id')->where('snacks.user_id', api_user()->id)->select('snack_foods.calories as calories', 'snack_foods.crabs as crabs', 'snack_foods.protein as protein', 'snack_foods.fat as fat');

            $dinners = Dinner::join('dinner_foods', 'dinner_foods.dinner_id', 'dinners.id')->where('dinners.user_id', api_user()->id)->select('dinner_foods.calories as calories', 'dinner_foods.crabs as crabs', 'dinner_foods.protein as protein', 'dinner_foods.fat as fat');

            //Over View
            $total_calories = api_user()->calories;
            $total_crabs = api_user()->crabs;
            $total_protein = api_user()->protein;
            $total_fat = api_user()->fat;

            $calories_eaten = $breakfasts->get()->sum('calories') + $lunches->get()->sum('calories') + $snacks->get()->sum('calories') + $dinners->get()->sum('calories');
            $calories_burned = 0;
            $crabs = $breakfasts->get()->sum('crabs') + $lunches->get()->sum('crabs') + $snacks->get()->sum('crabs') + $dinners->get()->sum('crabs');
            $protein = $breakfasts->get()->sum('protein') + $lunches->get()->sum('protein') + $snacks->get()->sum('protein') + $dinners->get()->sum('protein');
            $fat = $breakfasts->get()->sum('fat') + $lunches->get()->sum('fat') + $snacks->get()->sum('fat') + $dinners->get()->sum('fat');

            //Meals
            $date = Carbon::parse($request->filter_date);

            $breakfasts = $breakfasts->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->get();
            $breakfast_id = '';
            $breakfast_foods = [];
            foreach($breakfasts as $bFast){
                $breakfast_foods[] = get_dashboard_meals_food($bFast->food_id);
                $breakfast_id = $bFast->breakfast_id;
            }


            return response()->json([
                'calories_left' => $total_calories - $calories_eaten,
                'calories_eaten' => $calories_eaten,
                'calories_burned' => $calories_burned,
                'crabs' => $crabs . '/' . $total_crabs .' g',
                'protein' => $protein . '/' . $total_protein .' g',
                'fat' => $fat . '/' . $total_fat .' g',
                'meals' => [
                    'breakfast' => [
                        'id' => $breakfast_id,
                        'calories' => $breakfasts->sum('calories'),
                        'foods' => $breakfast_foods
                    ],
                ],
            ]);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
