<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Carbon\Carbon;
use App\Models\Water;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WaterSetting;
use Illuminate\Support\Facades\Validator;

class WaterController extends Controller
{
    public function waterSetting(Request $request)
    {
        $rules = [
            'pot_capacity' => 'required',
            'pot_type' => 'required',
            'goal' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getSetting = WaterSetting::where('user_id', api_user()->id)->first();
            if (!$getSetting) {
                $water = new WaterSetting();
                $water->user_id = api_user()->id;
            } else {
                $water = $getSetting;
            }
            $water->pot_capacity = $request->pot_capacity;
            $water->pot_type = $request->pot_type;
            $water->goal = $request->goal;
            $water->save();

            return response()->json(['result' => 'true', 'message' => 'Setting updated successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function getWaterSetting(Request $request)
    {
        try {
            $getSetting = WaterSetting::select('id', 'pot_capacity', 'pot_type', 'goal')->where('user_id', api_user()->id)->first();
            if ($getSetting) {
                $getSetting->goal_glass = $getSetting->goal / $getSetting->pot_capacity;
                return response()->json($getSetting);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data available']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addWater(Request $request)
    {
        $rules = [
            'date' => 'required',
            'water' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getData = Water::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getData) {
                $water = new Water();
                $water->user_id = api_user()->id;
                $water->drunk = $request->water;
                $water->date = Carbon::parse($request->date)->format('Y-m-d');
            } else {
                $water = $getData;
                $water->drunk += $request->water;
            }
            $water->save();

            return response()->json(['result' => 'true', 'message' => 'Water added successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function getWater(Request $request)
    {
        $rules = [
            'date' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getSetting = Water::select('drunk as water')->where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if ($getSetting) {
                return response()->json($getSetting);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data available for today']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
