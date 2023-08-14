<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            // $date = Carbon::parse($request->filter_date);
            // $data = $dinners->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day);

            // if ($data) {


            //     return response()->json($data);
            // } else {
            //     return response()->json(['result' => 'false', 'message' => 'No data found!']);
            // }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
