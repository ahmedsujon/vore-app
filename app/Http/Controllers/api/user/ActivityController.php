<?php

namespace App\Http\Controllers\api\user;

use Exception;
use Carbon\Carbon;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\UserActivityItem;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function allActivities(Request $request)
    {
        try {
            $activities = Activity::select('id', 'name', 'calories')->orderBy('name', 'ASC')->get();

            if($activities->count() > 0){
                return response()->json($activities);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No Activities Found']);
            }

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addNewActivity(Request $request)
    {
        $rules = [
            'name' => 'required',
            'calories' => 'required',
            'duration' => 'required',
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getActivity = Activity::where('name', $request->name)->first();
            if (!$getActivity) {
                $activity = new Activity();
                $activity->name = $request->name;
                $activity->calories = ($request->calories / $request->duration);
                $activity->status = 1;
                $activity->save();

                $activity_id = Activity::find($activity->id)->id;

                $getUserActivity = UserActivity::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
                if (!$getUserActivity) {
                    $user_activity = new UserActivity();
                    $user_activity->user_id = api_user()->id;
                    $user_activity->date = $request->date;
                    $user_activity->status = 1;
                    $user_activity->save();
                } else {
                    $user_activity = $getUserActivity;
                }

                $act_item = new UserActivityItem();
                $act_item->user_activity_id = $user_activity->id;
                $act_item->activity_id = $activity_id;
                $act_item->calories = $request->calories;
                $act_item->duration = $request->duration;
                $act_item->save();

                return response()->json(['result' => 'true', 'message' => 'New activity added successfully', 'activity_id' => $activity_id]);
            } else {
                return response()->json(['result' => 'false', 'message' => 'Activity already exists', 'activity_id' => $getActivity->id]);
            }

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function addUserActivity(Request $request)
    {
        $rules = [
            'activity_id' => 'required',
            'calories' => 'required',
            'duration' => 'required',
            'date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $getUserActivity = UserActivity::where('date', Carbon::parse($request->date)->format('Y-m-d'))->where('user_id', api_user()->id)->first();
            if (!$getUserActivity) {
                $user_activity = new UserActivity();
                $user_activity->user_id = api_user()->id;
                $user_activity->date = $request->date;
                $user_activity->status = 1;
                $user_activity->save();
            } else {
                $user_activity = $getUserActivity;
            }

            $act_item = new UserActivityItem();
            $act_item->user_activity_id = $user_activity->id;
            $act_item->activity_id = $request->activity_id;
            $act_item->calories = $request->calories * $request->duration;
            $act_item->duration = $request->duration;
            $act_item->save();

            return response()->json(['result' => 'true', 'message' => 'Activity added successfully']);

        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function userActivityDetails(Request $request)
    {
        try {
            $date = Carbon::parse($request->filter_date);

            $user_activity = UserActivity::select('id', 'date', 'created_at')->whereYear('date', $date->year)->whereMonth('date', $date->month)->whereDay('date', $date->day)->where('user_id', api_user()->id)->first();

            if ($user_activity) {
                $items = UserActivityItem::select('id', 'activity_id as activity', 'calories', 'duration')->where('user_activity_id', $user_activity->id)->get();

                foreach($items as $itm){
                    $itm->activity = Activity::find($itm->activity)->name;
                }

                $user_activity->total_activities = $items->count();
                $user_activity->total_calories = $items->sum('calories');
                $user_activity->activities = $items;

                return response()->json($user_activity);
            } else {
                return response()->json(['result' => 'false', 'message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }

    public function deleteUserActivity(Request $request){
        try {
            $item = UserActivityItem::where('id', $request->activity_id)->first();

            if ($item) {
                $item->delete();
                return response()->json(['result' => 'true','message' => 'Activity deleted successfully']);
            } else {
                return response()->json(['result' => 'false','message' => 'No data found!']);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage());
        }
    }
}
