<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Team;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        try {
            $members = Team::where('status', 1)->get();

            foreach ($members as $member) {
                $member->image = ($member->image == '') ? url('/') . '/' . 'assets/images/avatar.png' : url('/') . '/' . $member->image;
            }

            return response()->json($members);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
