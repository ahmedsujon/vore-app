<?php

namespace App\Http\Controllers\api\user\auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\WaterSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        //Validation
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = new User();
            $user->name = $request->name;
            $user->username = Str::lower(str_replace(' ', '', $request->name));
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            if ($user) {
                //Login Attempt
                $ttl = 1440;
                $credentials = $request->only('email', 'password');
                if ($token = $this->guard()->attempt($credentials)) {
                    return $this->respondWithToken($token, $ttl);
                }
            } else {
                return response()->json(['status' => 'false']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function makeProfile(Request $request)
    {
        //Calorie Calculations
        $total_calorie = 0;
        if($request->get('gender') == 'male'){
            $total_calorie = round($request->get('current_weight') * 24 * 0.85 * 1.2);
        } else {
            $total_calorie = round($request->get('current_weight') * 21.6 * 0.77 * 1.55);
        }

        $user = User::find(Auth::guard('user-api')->user()->id);
        $user->gender = $request->get('gender');
        $user->goal = $request->get('goal');
        $user->daily_activity_level = $request->get('daily_activity_level');
        $user->starting_weight = $request->get('current_weight');
        $user->starting_weight_unit = $request->get('current_weight_unit');
        $user->current_weight = $request->get('current_weight');
        $user->current_weight_unit = $request->get('current_weight_unit');
        $user->target_weight = $request->get('target_weight');
        $user->target_weight_unit = $request->get('target_weight_unit');
        $user->height = $request->get('height');
        $user->height_unit = $request->get('height_unit');
        $user->birth_date = $request->get('birth_date');
        $user->measurements = $request->get('measurements');
        $user->measurements_unit = $request->get('measurements_unit');

        $user->calories = $total_calorie;

        if($request->get('goal') == 'Maintain weight'){
            $user->crabs = $total_calorie > 0 ? round((($total_calorie * 0.5) / 4)) : 0;
            $user->fat = $total_calorie > 0 ? round((($total_calorie * 0.2) / 4)) : 0;
            $user->protein = $total_calorie > 0 ? round((($total_calorie * 0.3) / 9)) : 0;
        }
        if($request->get('goal') == 'Lose weight'){
            $user->crabs = $total_calorie > 0 ? round(((($total_calorie - 1000) * 0.5) / 4)) : 0;
            $user->fat = $total_calorie > 0 ? round(((($total_calorie - 1000) * 0.2) / 4)) : 0;
            $user->protein = $total_calorie > 0 ? round(((($total_calorie - 1000) * 0.3) / 9)) : 0;
        }
        if($request->get('goal') == 'Build muscle'){
            $user->crabs = $total_calorie > 0 ? round(((($total_calorie + 500) * 0.5) / 4)) : 0;
            $user->fat = $total_calorie > 0 ? round(((($total_calorie + 500) * 0.2) / 4)) : 0;
            $user->protein = $total_calorie > 0 ? round(((($total_calorie + 500) * 0.3) / 9)) : 0;
        }

        $user->save();

        $water_setting = new WaterSetting();
        $water_setting->user_id = $user->id;
        $water_setting->pot_capacity = 8;
        $water_setting->pot_type = 'glass';
        $water_setting->goal = 80;
        $water_setting->save();

        return response()->json(['result'=>'true', 'message' => 'Data updated successfully']);
    }

    public function login(Request $request)
    {
        //Validation
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // $userStatus = User::find($user->id)->suspended;
            // if ($userStatus == 0) {
            //Login Attempt
            $credentials = $request->only('email', 'password');
            $ttl = 1440;
            if ($request->remember_me == 1) {
                $ttl = 1051200;
            }
            if ($token = $this->guard()->setTTL($ttl)->attempt($credentials)) {
                return $this->respondWithToken($token, $ttl);
            }
            return response()->json(['error' => ['These credentials do not match our records.']], 401);
            // } else {
            //     return response()->json(['result' => 'false', 'message' => 'Your account has been suspended']);
            // }
        } else {
            return response()->json(['error' => ['These credentials do not match our records.']], 401);
        }
    }

    public function userProfile()
    {
        return response()->json($this->guard()->user());
    }

    public function userLogout()
    {
        $this->guard()->logout();

        return response()->json(['result'=>'true', 'message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh(), 1440);
    }

    protected function respondWithToken($token, $ttl)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl,
            'user' => $this->guard()->user(),
        ]);
    }

    public function guard()
    {
        return Auth::guard('user-api');
    }
}
