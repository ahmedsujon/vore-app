<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = User::select('name', 'username', 'avatar')->where('id', api_user()->id)->first();

            $user->avatar = url('/') . '/' . $user->avatar;

            return response()->json($user);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function profileDetails(Request $request)
    {
        try {
            $user = User::where('id', api_user()->id)->first();

            if($user->current_weight_unit == 'lbs'){
                $current_weight = round(($user->current_weight / 2.20462), 1);
            } else {
                $current_weight = $user->current_weight;
            }
            if($user->starting_weight_unit == 'lbs'){
                $starting_weight = round(($user->starting_weight / 2.20462), 1);
            } else {
                $starting_weight = $user->starting_weight;
            }

            $progress = 'No Change';
            if ($current_weight > $starting_weight) {
                $progress = ($current_weight - $starting_weight) . 'kg gained';
            } elseif ($current_weight < $starting_weight) {
                $progress = ($starting_weight - $current_weight) . 'kg lost';
            }



            $data = [
                'name' => $user->name,
                'username' => $user->username,
                'avatar' => url('/') . '/' . $user->avatar,
                'height' => $user->height,
                'weight' => ($user->current_weight_unit == 'kg' ? round(($user->current_weight * 2.20462), 1) : round($user->current_weight, 1)) . ' lbs',
                'weight' => ucfirst($user->gender),
                'goal' => $user->goal,
                'measurements' => $user->measurements,
                'progress' => $progress,
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

            if($user->current_weight_unit == 'lbs'){
                $current_weight = round(($user->current_weight / 2.20462), 1);
            } else {
                $current_weight = $user->current_weight;
            }
            if($user->starting_weight_unit == 'lbs'){
                $starting_weight = round(($user->starting_weight / 2.20462), 1);
            } else {
                $starting_weight = $user->starting_weight;
            }

            $progress = 'No Change';
            $change = 0;
            if ($current_weight > $starting_weight) {
                $progress = ($current_weight - $starting_weight) . 'kg gained';
                $change =($current_weight / $starting_weight) * 100;
            } elseif ($current_weight < $starting_weight) {
                $progress = ($starting_weight - $current_weight) . 'kg lost';
                $change =($current_weight / $starting_weight) * 100;
            }

            $data = [
                'progress' => $progress,
                'start' => $starting_weight,
                'current' => $current_weight,
                'change' => $change,
            ];

            return response()->json($data);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
