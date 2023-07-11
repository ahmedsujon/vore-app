<?php

namespace App\Http\Controllers\api\user\auth;

use Exception;
use App\Models\User;
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
        $user = User::find(Auth::guard('user-api')->user()->id);
        $user->gender = $request->get('gender');
        $user->goal = $request->get('goal');
        $user->daily_activity_level = $request->get('daily_activity_level');
        $user->current_weight = $request->get('current_weight');
        $user->current_weight_unit = $request->get('current_weight_unit');
        $user->target_weight = $request->get('target_weight');
        $user->target_weight_unit = $request->get('target_weight_unit');
        $user->height = $request->get('height');
        $user->height_unit = $request->get('height_unit');
        $user->birth_date = $request->get('birth_date');
        $user->measurements = $request->get('measurements');
        $user->measurements_unit = $request->get('measurements_unit');
        $user->save();

        return response($user);
        return response()->json(['success' => ['These credentials do not match our records.']], 401);
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

        return response()->json(['message' => ['Successfully logged out']]);
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
