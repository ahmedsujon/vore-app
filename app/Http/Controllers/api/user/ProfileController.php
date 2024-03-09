<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Models\UserMeasurement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = User::select('name', 'username', 'avatar')->where('id', api_user()->id)->first();

            $user->avatar = ($user->avatar ==  '') ? url('/') . '/' . 'assets/images/avatar.png' : url('/') . '/' . $user->avatar;

            return response()->json($user);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function profileDetails(Request $request)
    {
        try {
            $user = User::where('id', api_user()->id)->first();

            if($user->current_weight_unit == 'kg'){
                $current_weight = round(($user->current_weight * 2.20462), 1);
            } else {
                $current_weight = $user->current_weight;
            }
            if($user->starting_weight_unit == 'kg'){
                $starting_weight = round(($user->starting_weight * 2.20462), 1);
            } else {
                $starting_weight = $user->starting_weight;
            }

            $progress = 'No Change';
            if ($current_weight > $starting_weight) {
                $progress = (round(($current_weight - $starting_weight),2)) . 'lbs gained';
            } elseif ($current_weight < $starting_weight) {
                $progress = (round(($starting_weight - $current_weight),2)) . 'lbs lost';
            }

            $user_measurements = DB::table('user_measurements')->select('name', 'value', 'unit')->where('user_id', api_user()->id)->get();
            // $measurements = [];
            // foreach ($user_measurements as $key => $user_mes) {
            //     $measurements[$user_mes->name] = $user_mes->value . ' ' . $user_mes->unit;
            // }

            $measurements = UserMeasurement::select('id', 'name', 'value', 'unit', 'icon', 'updated_at as measured_at')->where('user_id', api_user()->id)->get();

            foreach ($measurements as $mes) {
                $mes->icon = url('/') . '/' . $mes->icon;
            }

            $data = [
                'name' => $user->name,
                'username' => $user->username,
                'avatar' => ($user->avatar ==  '') ? url('/') . '/' . 'assets/images/avatar.png' : url('/') . '/' . $user->avatar,
                'height' => $user->height,
                'weight' => ($user->current_weight_unit == 'kg' ? round(($user->current_weight * 2.20462), 1) : round($user->current_weight, 1)) . ' lbs',
                'gender' => ucfirst($user->gender),
                'goal' => $user->goal,
                'measurements' => $measurements,
                'progress' => $progress,
                'target_weight' => $user->target_weight,
                'target_weight_unit' => $user->target_weight_unit,
                'height' => $user->height,
                'birthdate' => $user->birth_date,
            ];

            return response()->json($data);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'name' => 'required',
            'goal' => 'required',
            'gender' => 'required',
            'target_weight' => 'required',
            'target_weight_unit' => 'required',
            'height' => 'required',
            'birthdate' => 'required',
            // 'avatar' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = User::find(api_user()->id);
            $user->name = $request->name;
            if ($request->username) {
                $user->username = $request->username;
            }
            $user->goal = $request->goal;
            $user->gender = $request->gender;
            $user->target_weight = $request->target_weight;
            $user->target_weight_unit = $request->target_weight_unit;
            $user->height = $request->height;
            $user->birth_date = $request->birthdate;
            if ($request->file('avatar')) {
                $user->avatar = uploadFile($request->file('avatar'), 'profile_images');
            }
            $user->save();

            return response()->json(['result' => 'true', 'message' => 'Profile updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function progress(Request $request)
    {
        try {
            $user = User::where('id', api_user()->id)->first();

            if($user->current_weight_unit == 'kg'){
                $current_weight = round(($user->current_weight * 2.20462), 1);
            } else {
                $current_weight = $user->current_weight;
            }
            if($user->starting_weight_unit == 'kg'){
                $starting_weight = round(($user->starting_weight * 2.20462), 1);
            } else {
                $starting_weight = $user->starting_weight;
            }

            $progress = 'No Change';
            $change = 0;
            if ($current_weight > $starting_weight) {
                $progress = (round(($current_weight - $starting_weight), 2)) . ' lbs gained';
                $change = round(((($current_weight -$starting_weight) / $starting_weight) * 100), 2);
            } elseif ($current_weight < $starting_weight) {
                $progress = (round(($starting_weight - $current_weight), 2)) . ' lbs lost';
                $change = abs(round(((($current_weight - $starting_weight) / $starting_weight) * 100), 2));
            }

            $graph_value = [];
            $day = $request->time ? $request->time : 30;
            $date = Carbon::today()->subDays($day);
            $measurements = Measurement::where('user_id', api_user()->id)->where('date', '>', $date)->orderBy('date', 'ASC')->get();
            foreach ($measurements as $key => $measurement) {
                $graph_value[] = [(int) Carbon::parse($measurement->date)->format('d'),$measurement->weight];
            }

            $data = [
                'progress' => $progress,
                'start' => $starting_weight,
                'current' => $current_weight,
                'change' => $change,
                'graph' => $graph_value,
            ];

            return response()->json($data);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function myGoals(Request $request)
    {
        try {
            $user = User::where('id', api_user()->id)->first();

            if($user->current_weight_unit == 'kg'){
                $current_weight = round(($user->current_weight * 2.20462), 1);
            } else {
                $current_weight = $user->current_weight;
            }
            if($user->starting_weight_unit == 'kg'){
                $starting_weight = round(($user->starting_weight * 2.20462), 1);
            } else {
                $starting_weight = $user->starting_weight;
            }

            if($user->target_weight_unit == 'kg'){
                $goal_weight = round(($user->target_weight * 2.20462), 1);
            } else {
                $goal_weight = $user->target_weight;
            }

            $data = [
                'goal' => $user->goal,
                'starting_weight' => $starting_weight . ' lb',
                'current_weight' => $current_weight . ' lb',
                'goal_weight' => $goal_weight . ' lb',
                'activity_level' => $user->daily_activity_level,
                'weekly_goal' => 0 . ' lb',
                'calorie_goal' => $user->calories,
                'steps' => 0,
                'nutrient_goals' => 'Default',
            ];

            return response()->json($data);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function updateMyGoals(Request $request)
    {
        $rules = [
            'daily_activity_level' => 'required',
            'goal' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = User::find(api_user()->id);

            //Calorie Calculations
            $total_calorie = 0;
            $activity_level = 1;

            if ($request->get('daily_activity_level') == 'Couch Potato') {
                $activity_level = 1.2;
            }

            if ($request->get('daily_activity_level') == 'Lightly Active') {
                $activity_level = 1.375;
            }

            if ($request->get('daily_activity_level') == 'Moderately Active') {
                $activity_level = 1.55;
            }

            if ($request->get('daily_activity_level') == 'Very Active') {
                $activity_level = 1.725;
            }

            if ($request->get('daily_activity_level') == 'Extremely Active') {
                $activity_level = 1.9;
            }

            if ($user->current_weight_unit == 'lbs') {
                $current_weight = $user->current_weight * 0.453592;
            } else {
                $current_weight = $user->current_weight;
            }

            if ($user->gender == 'Male') {
                $total_calorie = round($current_weight * 24 * 0.85 * $activity_level);
            } else {
                $total_calorie = round($current_weight * 21.6 * 0.77 * $activity_level);
            }

            $user->goal = $request->get('goal');
            $user->daily_activity_level = $request->get('daily_activity_level');
            $user->calories = $total_calorie;

            if ($request->get('goal') == 'Maintain weight') {
                $user->crabs = $total_calorie > 0 ? round((($total_calorie * 0.5) / 4)) : 0;
                $user->protein = $total_calorie > 0 ? round((($total_calorie * 0.2) / 4)) : 0;
                $user->fat = $total_calorie > 0 ? round((($total_calorie * 0.3) / 9)) : 0;
            }
            if ($request->get('goal') == 'Lose weight') {
                $user->crabs = $total_calorie > 0 ? round(((($total_calorie - 1000) * 0.5) / 4)) : 0;
                $user->protein = $total_calorie > 0 ? round(((($total_calorie - 1000) * 0.2) / 4)) : 0;
                $user->fat = $total_calorie > 0 ? round(((($total_calorie - 1000) * 0.3) / 9)) : 0;
            }
            if ($request->get('goal') == 'Build muscle') {
                $user->crabs = $total_calorie > 0 ? round(((($total_calorie + 500) * 0.5) / 4)) : 0;
                $user->protein = $total_calorie > 0 ? round(((($total_calorie + 500) * 0.2) / 4)) : 0;
                $user->fat = $total_calorie > 0 ? round(((($total_calorie + 500) * 0.3) / 9)) : 0;
            }

            $user->save();

            return response()->json(['result' => 'true', 'message' => 'Goal updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function nutrientGoals(Request $request)
    {
        try {
            $user = User::where('id', api_user()->id)->first();
            $data = [
                'crabs' => [
                    'cal' => $user->crabs,
                    'gram' => round($user->crabs / 4),
                    'value' => 50,
                ],
                'protein' => [
                    'cal' => $user->protein,
                    'gram' => round($user->protein / 4),
                    'value' => 30,
                ],
                'fat' => [
                    'cal' => $user->fat,
                    'gram' => round($user->fat / 9),
                    'value' => 20,
                ],
            ];

            return response()->json($data);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
