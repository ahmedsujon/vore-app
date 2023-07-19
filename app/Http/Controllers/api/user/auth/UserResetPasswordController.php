<?php

namespace App\Http\Controllers\api\user\auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserResetPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $getUser = User::where('email', $request->email)->first();
        if ($getUser != '') {
            $this->send($request->email);
            return $this->successResponse();
        } else {
            return $this->failedResponse();
        }
    }

    public function send($email)
    {
        $data['email'] = $email;
        $data['token'] = $this->createToken($email);

        Mail::send('emails.api.forget-password', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Reset Password');
        });
    }

    public function createToken($email)
    {
        $oldToken = DB::table('password_reset_tokens')->where('email', $email)->first();

        if ($oldToken) {
            $otp = rand(10000000, 99999999);
            DB::table('password_reset_tokens')->update([
                'otp' => $otp,
                'created_at' => Carbon::now()
            ]);
            return [
                'token' => $oldToken->token,
                'otp' => $otp
            ];
        } else {
            $token = Str::random(40);
            $otp = rand(10000000, 99999999);

            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token,
                'otp' => $otp,
                'created_at' => Carbon::now()
            ]);

            return [
                'token' => $token,
                'otp' => $otp
            ];
        }
    }

    public function failedResponse()
    {
        return response()->json([
            'error' => 'No user found with this email'
        ], Response::HTTP_NOT_FOUND);
    }

    public function successResponse()
    {
        return response()->json([
            'success' => 'Password reset email has beed sent successfully, please check your inbox.'
        ], Response::HTTP_OK);
    }

    //Change Password
    public function changePassword(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $getRequest = DB::table('password_reset_tokens')->where('email', $request->email)->where('otp', $request->otp)->first();
        if ($getRequest) {
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_reset_tokens')->where('email', $request->email)->where('otp', $request->otp)->delete();

            return response()->json(['success' => 'Password updated successfully']);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Incorrect OTP'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
