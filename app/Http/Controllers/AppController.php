<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function verifyEmail(Request $request)
    {
        $token = request()->get('token');

        $user = User::where('email_verification_token', $token)->first();
        if ($user) {
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            return view('auth.email-verified');
        } else {
            abort(404);
        }
    }
}
