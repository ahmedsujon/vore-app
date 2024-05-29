<?php

namespace App\Http\Controllers\api\user\auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function sendEmailVerificationMail(Request $request)
    {
        $token = Str::lower(Str::random(40)) . api_user()->id . time();

        $user = User::find(api_user()->id);
        $user->email_verification_token = $token;
        $user->save();

        $data['email'] = api_user()->email;
        $data['token'] = $token;
        $data['name'] = api_user()->name;

        Mail::send('emails.api.email-verification', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Email Verification');
        });

        return response()->json(['result' => true, 'message' => 'Verification Email Sent']);
    }

    public function getVerificationStatus(Request $request)
    {
        try {
            if (api_user()->email_verified_at != null) {
                return response()->json(['result' => true, 'message' => 'Verified']);
            } else {
                return response()->json(['result' => false, 'message' => 'Not Verified']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
