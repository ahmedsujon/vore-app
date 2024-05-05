<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function contactUs(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->description = $request->message;
            $contact->save();

            return response()->json(['result' => 'true', 'message' => 'Contact message sent successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
