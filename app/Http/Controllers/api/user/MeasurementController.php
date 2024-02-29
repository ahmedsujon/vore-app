<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Illuminate\Http\Request;
use App\Models\UserMeasurement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MeasurementController extends Controller
{
    public function allMeasurements(Request $request)
    {
        try {
            $measurements = UserMeasurement::select('id', 'name', 'value', 'unit', 'icon', 'updated_at as measured_at')->where('user_id', api_user()->id)->get();

            foreach ($measurements as $mes) {
                $mes->icon = url('/') . '/' . $mes->icon;
            }

            if($measurements->count() > 0){
                return response()->json($measurements);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No Data Found']);
            }

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addMeasurement(Request $request)
    {
        $rules = [
            'name' => 'required',
            'unit' => 'required',
            'value' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getData = UserMeasurement::where('name', $request->name)->where('user_id', api_user()->id)->first();
            if (!$getData) {
                $measurement = new UserMeasurement();
                $measurement->user_id = api_user()->id;
                $measurement->name = $request->get('name');
                $measurement->unit = $request->get('unit');
                $measurement->value = $request->get('value');
                $measurement->save();

                return response()->json(['result' => 'true', 'message' => 'New measurement added successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'Measurement already added']);
            }

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function editMeasurement(Request $request)
    {
        $rules = [
            'measurement_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $measurement = UserMeasurement::select('id', 'name', 'value', 'unit')->where('id', $request->get('measurement_id'))->first();
            return response()->json($measurement);
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
    public function updateMeasurement(Request $request)
    {
        $rules = [
            'measurement_id' => 'required',
            'name' => 'required',
            'unit' => 'required',
            'value' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getData = UserMeasurement::where('id', '!=', $request->get('measurement_id'))->where('name', $request->name)->where('user_id', api_user()->id)->first();
            if (!$getData) {
                $measurement = UserMeasurement::find($request->get('measurement_id'));
                $measurement->user_id = api_user()->id;
                $measurement->name = $request->get('name');
                $measurement->unit = $request->get('unit');
                $measurement->value = $request->get('value');
                $measurement->save();

                return response()->json(['result' => 'true', 'message' => 'Measurement updated successfully']);
            } else {
                return response()->json(['result' => 'false', 'message' => 'Measurement already exists']);
            }

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
