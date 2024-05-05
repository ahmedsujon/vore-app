<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\User;
use App\Models\UserMeasurement;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = User::select('name', 'username', 'avatar')->where('id', api_user()->id)->first();

            $user->avatar = ($user->avatar == '') ? url('/') . '/' . 'assets/images/avatar.png' : url('/') . '/' . $user->avatar;

            return response()->json($user);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function profileDetails(Request $request)
    {
        try {
            $user = User::where('id', api_user()->id)->first();

            if ($user->current_weight_unit == 'kg') {
                $current_weight = round(($user->current_weight * 2.20462), 1);
            } else {
                $current_weight = $user->current_weight;
            }
            if ($user->starting_weight_unit == 'kg') {
                $starting_weight = round(($user->starting_weight * 2.20462), 1);
            } else {
                $starting_weight = $user->starting_weight;
            }

            $progress = 'No Change';
            if ($current_weight > $starting_weight) {
                $progress = (round(($current_weight - $starting_weight), 2)) . 'lbs gained';
            } elseif ($current_weight < $starting_weight) {
                $progress = (round(($starting_weight - $current_weight), 2)) . 'lbs lost';
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
                'avatar' => ($user->avatar == '') ? url('/') . '/' . 'assets/images/avatar.png' : url('/') . '/' . $user->avatar,
                'weight' => ($user->current_weight_unit == 'kg' ? round(($user->current_weight * 2.20462), 1) : round($user->current_weight, 1)) . ' lbs',
                'gender' => ucfirst($user->gender),
                'goal' => $user->goal,
                'measurements' => $measurements,
                'progress' => $progress,
                'target_weight' => $user->target_weight,
                'target_weight_unit' => $user->target_weight_unit,
                'height' => $user->height,
                'height_unit' => $user->height_unit,
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
            'height_unit' => 'required',
            'birthdate' => 'required',
            // 'avatar' => 'required',
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

            if ($user->daily_activity_level == 'Couch Potato') {
                $activity_level = 1.2;
            }
            if ($user->daily_activity_level == 'Lightly Active') {
                $activity_level = 1.55;
            }
            if ($user->daily_activity_level == 'Moderately Active') {
                $activity_level = 1.725;
            }
            if ($user->daily_activity_level == 'Extremely Active') {
                $activity_level = 1.9;
            }

            if ($user->current_weight_unit == 'lbs') {
                $current_weight = $user->current_weight * 0.45;
            } else {
                $current_weight = $user->current_weight;
            }

            if ($request->get('height_unit') == 'ft') {
                $get_height = explode('.', $request->get('height'));

                $height_ft = ($get_height[0] * 12) * 2.54;
                $height_in = $get_height[1] * 2.54;

                $height = $height_ft + $height_in;
            } else {
                $height = $request->get('height');
            }

            $age = $this->calculateAge($request->get('birthdate'));

            if ($request->get('gender') == 'Male') {
                $total_calorie = round((88.362 + (13.397 * $current_weight) + (4.799 * $height) - (5.677 * $age)) * $activity_level, 2);
            } else {
                $total_calorie = round((447.593 + (9.247 * $current_weight) + (3.098 * $height) - (4.33 * $age)) * $activity_level, 2);
            }

            $user->name = $request->get('name');
            if ($request->get('username')) {
                $user->username = $request->get('username');
            }
            $user->goal = $request->get('goal');
            $user->gender = $request->get('gender');
            $user->target_weight = $request->get('target_weight');
            $user->target_weight_unit = $request->get('target_weight_unit');
            $user->height = $request->get('height');
            $user->height_unit = $request->get('height_unit');
            $user->birth_date = $request->get('birthdate');

            $weekly_goal = $user->weekly_goal;
            if ($weekly_goal == 1) {
                $weekly_value = 250;
            }if ($weekly_goal == 2) {
                $weekly_value = 500;
            }if ($weekly_goal == 3) {
                $weekly_value = 750;
            }if ($weekly_goal == 4) {
                $weekly_value = 1000;
            }

            if ($request->file('avatar')) {
                $user->avatar = uploadFile($request->file('avatar'), 'profile_images');
            }

            if ($request->get('goal') == 'Maintain weight') {
                $user->crabs = $total_calorie > 0 ? round((($total_calorie * 0.5) / 4), 2) : 0;
                $user->protein = $total_calorie > 0 ? round((($total_calorie * 0.3) / 4), 2) : 0;
                $user->fat = $total_calorie > 0 ? round((($total_calorie * 0.2) / 9), 2) : 0;

                $user->calories = round($total_calorie);
            }
            if ($request->get('goal') == 'Lose weight') {
                $user->crabs = $total_calorie > 0 ? round(((($total_calorie - $weekly_value) * 0.5) / 4), 2) : 0;
                $user->protein = $total_calorie > 0 ? round(((($total_calorie - $weekly_value) * 0.3) / 4), 2) : 0;
                $user->fat = $total_calorie > 0 ? round(((($total_calorie - $weekly_value) * 0.2) / 9), 2) : 0;

                $user->calories = round($total_calorie - $weekly_value);
            }
            if ($request->get('goal') == 'Build muscle') {
                $user->crabs = $total_calorie > 0 ? round(((($total_calorie + $weekly_value) * 0.5) / 4), 2) : 0;
                $user->protein = $total_calorie > 0 ? round(((($total_calorie + $weekly_value) * 0.3) / 4), 2) : 0;
                $user->fat = $total_calorie > 0 ? round(((($total_calorie + $weekly_value) * 0.2) / 9), 2) : 0;

                $user->calories = round($total_calorie + $weekly_value);
            }

            $user->save();

            // return response()->json($user);
            return response()->json(['result' => 'true', 'message' => 'Profile updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function progress(Request $request)
    {
        try {
            $user = User::where('id', api_user()->id)->first();

            if ($user->current_weight_unit == 'kg') {
                $current_weight = round(($user->current_weight * 2.20462), 1);
            } else {
                $current_weight = $user->current_weight;
            }
            if ($user->starting_weight_unit == 'kg') {
                $starting_weight = round(($user->starting_weight * 2.20462), 1);
            } else {
                $starting_weight = $user->starting_weight;
            }

            $progress = 'No Change';
            $change = 0;
            if ($current_weight > $starting_weight) {
                $progress = (round(($current_weight - $starting_weight), 2)) . ' lbs gained';
                $change = round(((($current_weight - $starting_weight) / $starting_weight) * 100), 2);
            } elseif ($current_weight < $starting_weight) {
                $progress = (round(($starting_weight - $current_weight), 2)) . ' lbs lost';
                $change = abs(round(((($current_weight - $starting_weight) / $starting_weight) * 100), 2));
            }

            $graph_value = [];
            $day = $request->time ? $request->time : 30;
            $date = Carbon::today()->subDays($day);
            $measurements = Measurement::where('user_id', api_user()->id)->where('date', '>', $date)->orderBy('date', 'ASC')->get();
            foreach ($measurements as $key => $measurement) {
                $graph_value[] = [(int) Carbon::parse($measurement->date)->format('d'), $measurement->weight];
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

            if ($user->current_weight_unit == 'kg') {
                $current_weight = round(($user->current_weight * 2.20462), 1);
            } else {
                $current_weight = $user->current_weight;
            }
            if ($user->starting_weight_unit == 'kg') {
                $starting_weight = round(($user->starting_weight * 2.20462), 1);
            } else {
                $starting_weight = $user->starting_weight;
            }

            if ($user->target_weight_unit == 'kg') {
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
            'current_weight' => 'required',
            'target_weight' => 'required',
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
                $activity_level = 1.55;
            }

            if ($request->get('daily_activity_level') == 'Moderately Active') {
                $activity_level = 1.725;
            }

            if ($request->get('daily_activity_level') == 'Extremely Active') {
                $activity_level = 1.9;
            }

            // if ($user->current_weight_unit == 'lbs') {
            $current_weight = $request->get('current_weight') * 0.45;
            // } else {
            //     $current_weight = $request->get('current_weight');
            // }

            if ($user->height_unit == 'ft') {
                $get_height = explode('.', $user->height);

                $height_ft = ($get_height[0] * 12) * 2.54;
                $height_in = $get_height[1] * 2.54;

                $height = $height_ft + $height_in;
            } else {
                $height = $user->height;
            }

            $age = $this->calculateAge($user->birth_date);

            if ($user->gender == 'Male') {
                $total_calorie = round((88.362 + (13.397 * $current_weight) + (4.799 * $height) - (5.677 * $age)) * $activity_level, 2);
            } else {
                $total_calorie = round((447.593 + (9.247 * $current_weight) + (3.098 * $height) - (4.33 * $age)) * $activity_level, 2);
            }

            $user->goal = $request->get('goal');
            $user->daily_activity_level = $request->get('daily_activity_level');
            $user->calories = round($total_calorie);
            $user->starting_weight = $request->get('current_weight');
            $user->starting_weight_unit = 'lbs';
            $user->current_weight = $request->get('current_weight');
            $user->current_weight_unit = 'lbs';
            $user->target_weight = $request->get('target_weight');
            $user->target_weight_unit = 'lbs';

            $weekly_goal = $user->weekly_goal;
            if ($weekly_goal == 1) {
                $weekly_value = 250;
            }if ($weekly_goal == 2) {
                $weekly_value = 500;
            }if ($weekly_goal == 3) {
                $weekly_value = 750;
            }if ($weekly_goal == 4) {
                $weekly_value = 1000;
            }

            if ($request->get('goal') == 'Maintain weight') {
                $user->crabs = $total_calorie > 0 ? round((($total_calorie * 0.5) / 4), 2) : 0;
                $user->protein = $total_calorie > 0 ? round((($total_calorie * 0.3) / 4), 2) : 0;
                $user->fat = $total_calorie > 0 ? round((($total_calorie * 0.2) / 9), 2) : 0;

                $user->calories = round($total_calorie);
            }
            if ($request->get('goal') == 'Lose weight') {
                $user->crabs = $total_calorie > 0 ? round(((($total_calorie - $weekly_value) * 0.5) / 4), 2) : 0;
                $user->protein = $total_calorie > 0 ? round(((($total_calorie - $weekly_value) * 0.3) / 4), 2) : 0;
                $user->fat = $total_calorie > 0 ? round(((($total_calorie - $weekly_value) * 0.2) / 9), 2) : 0;

                $user->calories = round($total_calorie - $weekly_value);
            }
            if ($request->get('goal') == 'Build muscle') {
                $user->crabs = $total_calorie > 0 ? round(((($total_calorie + $weekly_value) * 0.5) / 4), 2) : 0;
                $user->protein = $total_calorie > 0 ? round(((($total_calorie + $weekly_value) * 0.3) / 4), 2) : 0;
                $user->fat = $total_calorie > 0 ? round(((($total_calorie + $weekly_value) * 0.2) / 9), 2) : 0;

                $user->calories = round($total_calorie + $weekly_value);
            }

            $user->save();

            return response()->json(['result' => 'true', 'message' => 'Goal updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    private function calculateAge($dateOfBirth)
    {
        // Assuming $dateOfBirth is a string in the format 'YYYY-MM-DD'
        $birthDate = Carbon::parse($dateOfBirth);
        $currentDate = Carbon::now();

        // Calculate the difference between the current date and the date of birth
        $age = $currentDate->diffInYears($birthDate);

        return $age;
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
