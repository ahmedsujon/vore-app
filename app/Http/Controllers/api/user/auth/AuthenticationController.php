<?php

namespace App\Http\Controllers\api\user\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMeasurement;
use App\Models\WaterSetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            'device_token' => 'required',
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
            $user->password_text = $request->password;
            $user->device_token = $request->device_token;
            $user->save();

            if ($user) {
                //Login Attempt
                $ttl = 1440;
                $credentials = $request->only('email', 'password');
                if ($token = $this->guard()->attempt($credentials)) {
                    $this->sendEmailVerificationMail($request->email, $request->name);
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
        $rules = [
            'gender' => 'required',
            'goal' => 'required',
            'daily_activity_level' => 'required',
            'current_weight' => 'required',
            'current_weight_unit' => 'required',
            'target_weight' => 'required',
            'target_weight_unit' => 'required',
            'height' => 'required',
            'height_unit' => 'required',
            'weekly_goal' => 'required',
            'birth_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
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

            // if ($request->get('daily_activity_level') == 'Very Active') {
            //     $activity_level = 1.725;
            // }

            if ($request->get('daily_activity_level') == 'Extremely Active') {
                $activity_level = 1.9;
            }

            if ($request->get('current_weight_unit') == 'lbs') {
                $current_weight = $request->get('current_weight') * 0.45;
            } else {
                $current_weight = $request->get('current_weight');
            }

            if ($request->get('height_unit') == 'ft') {
                $get_height = explode('.', $request->get('height'));

                $height_ft = ($get_height[0] * 12) * 2.54;
                $height_in = $get_height[1] * 2.54;

                $height = $height_ft + $height_in;
            } else {
                $height = $request->get('height');
            }

            $age = $this->calculateAge($request->get('birth_date'));

            if ($request->get('gender') == 'Male') {
                $total_calorie = round((88.362 + (13.397 * $current_weight) + (4.799 * $height) - (5.677 * $age)) * $activity_level, 2);
            } else {
                $total_calorie = round((447.593 + (9.247 * $current_weight) + (3.098 * $height) - (4.33 * $age)) * $activity_level, 2);
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
            $user->weekly_goal = $request->get('weekly_goal');

            $weekly_goal = $request->get('weekly_goal');
            $weekly_goal_value = 0;
            if ($weekly_goal == 1) {
                $weekly_goal_value = 0.2; //in kg
                $weekly_value = 250;
            }if ($weekly_goal == 2) {
                $weekly_goal_value = 0.5; //in kg
                $weekly_value = 500;
            }if ($weekly_goal == 3) {
                $weekly_goal_value = 0.7; //in kg
                $weekly_value = 750;
            }if ($weekly_goal == 4) {
                $weekly_goal_value = 1; //in kg
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

            // return $user;

            $water_setting = new WaterSetting();
            $water_setting->user_id = $user->id;
            $water_setting->pot_capacity = 8;
            $water_setting->pot_type = 'glass';
            $water_setting->goal = 80;
            $water_setting->save();

            $measurements = ["Chest", "Hips", "Waist", "Thighs", "Upper Arms", "Body Fat", "Muscle Mass"];
            //"Blood Glucose", "Blood Pressure",
            $units = ["in", "in", "in", "in", "in", "%", "lbs"];
            foreach ($measurements as $key => $value) {
                $getMes = UserMeasurement::where('name', $value)->where('user_id', api_user()->id)->first();
                if (!$getMes) {
                    $mes = new UserMeasurement();
                    $mes->user_id = $user->id;
                    $mes->name = $value;
                    $mes->unit = $units[$key];
                    $mes->value = 0;
                    if ($key == 0) {
                        $mes->icon = 'assets/app/measurements/chest.png';
                    } else if ($key == 1) {
                        $mes->icon = 'assets/app/measurements/hips.png';
                    } else if ($key == 2) {
                        $mes->icon = 'assets/app/measurements/waist.png';
                    } else if ($key == 3) {
                        $mes->icon = 'assets/app/measurements/thigh.png';
                    } else if ($key == 4) {
                        $mes->icon = 'assets/app/measurements/muscle.png';
                    } else if ($key == 5) {
                        $mes->icon = 'assets/app/measurements/body_fat.png';
                    } else if ($key == 6) {
                        $mes->icon = 'assets/app/measurements/muscle_mass.png';
                    }
                    $mes->save();
                }
            }

            // Journey Calculation Starts
            if ($request->get('target_weight_unit') == 'lbs') {
                $target_weight = $request->get('target_weight') * 0.45;
            } else {
                $target_weight = $request->get('target_weight');
            }

            $journey = [];
            if ($request->get('goal') == 'Maintain weight') {

            }
            if ($request->get('goal') == 'Lose weight') {
                $split_number = ($current_weight - $target_weight) / $weekly_goal_value;
                $total_days = round($split_number * 7);

                $journey[] = [
                    'start_from' => 'Today',
                    'start_date' => Carbon::parse(now())->format('F d, Y'),
                    'end_date' => Carbon::parse(now()->addDays($total_days))->format('F d, Y'),
                    'goal' => 'Lose Weight',
                    'current_weight' => $request->get('current_weight') . ' ' . $request->get('current_weight_unit'),
                    'target_weight' => $request->get('target_weight') . ' ' . $request->get('target_weight_unit'),
                    'graph_type' => 'top-to-bottom',
                ];

            }
            if ($request->get('goal') == 'Build muscle') {
                $split_number = ($target_weight - $current_weight) / $weekly_goal_value;
                $total_days = round($split_number * 7);

                $journey[] = [
                    'start_from' => 'Today',
                    'start_date' => Carbon::parse(now())->format('F d, Y'),
                    'end_date' => Carbon::parse(now()->addDays($total_days))->format('F d, Y'),
                    'goal' => 'Build Muscle',
                    'current_weight' => $request->get('current_weight') . ' ' . $request->get('current_weight_unit'),
                    'target_weight' => $request->get('target_weight') . ' ' . $request->get('target_weight_unit'),
                    'graph_type' => 'bottom-to-top',
                ];
            }

            $this->emailVerificationReminder(api_user()->id);

            return response()->json(['result' => 'true', 'message' => 'Data updated successfully', 'journey' => $journey]);
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

    public function login(Request $request)
    {
        //Validation
        $rules = [
            'email' => 'required_if:login_type,email',
            'password' => 'required_if:login_type,email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->login_type == 'email') {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $credentials = $request->only('email', 'password');
                $ttl = 1440;
                if ($request->remember_me == 1) {
                    $ttl = 1051200;
                }
                if ($token = $this->guard()->setTTL($ttl)->attempt($credentials)) {
                    return $this->respondWithToken($token, $ttl);
                }
                return response()->json(['error' => ['These credentials do not match our records.']], 401);
            } else {
                return response()->json(['error' => ['These credentials do not match our records.']], 401);
            }
        } else {
            $user = User::where('device_token', $request->device_token)->first();

            if ($user) {
                $credentials = ['email' => $user->email, 'password' => $user->password_text];
                $ttl = 1440;
                if ($request->remember_me == 1) {
                    $ttl = 1051200;
                }
                if ($token = $this->guard()->setTTL($ttl)->attempt($credentials)) {
                    return $this->respondWithToken($token, $ttl);
                }
                return response()->json(['error' => ['These credentials do not match our records.']], 401);
            } else {
                return response()->json(['error' => ['These credentials do not match our records.']], 401);
            }
        }
    }

    public function userProfile()
    {
        return response()->json($this->guard()->user());
    }

    public function userLogout()
    {
        $this->guard()->logout();

        return response()->json(['result' => 'true', 'message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh(), 1440);
    }

    protected function respondWithToken($token, $ttl)
    {
        $user = $this->guard()->user();
        $user->height = (float) $user->height;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl,
            'user' => $user,
        ]);
    }

    public function sendEmailVerificationMail($email, $name)
    {
        $token = Str::lower(Str::random(40)) . api_user()->id . time();

        $user = User::find(api_user()->id);
        $user->email_verification_token = $token;
        $user->save();


        $data['email'] = $email;
        $data['token'] = $token;
        $data['name'] = $name;

        Mail::send('emails.api.email-verification', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Email Verification');
        });
    }

    public function emailVerificationReminder($user_id)
    {
        dispatch(function () use ($user_id) {
            $user = User::find($user_id);

            $mailData['email'] = $user->email;
            $mailData['token'] = $user->email_verification_token;
            $mailData['name'] = $user->name;

            if ($user->email_verified_at == NULL) {
                Mail::send('emails.api.email-verification-reminder', $mailData, function ($message) use ($mailData) {
                    $message->to($mailData['email'])
                        ->subject('Email Verification');
                });

                $this->emailVerificationReminder($user->id);
            }
        })->delay(Carbon::now()->addDays(7));
    }

    public function guard()
    {
        return Auth::guard('user-api');
    }
}
