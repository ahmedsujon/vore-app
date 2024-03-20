<?php

use Carbon\Carbon;
use App\Models\Food;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

// Api
function api_user(){
    return Auth::guard('user-api')->user();
}

function get_meals_food($food, $meal){
    $getFood = Food::select('id', 'food_unique_id', 'is_fat_secret', 'name', 'slug', 'nutrations', 'barcode', 'images')->find($food['food_id']);

    $imgs = [];

    if($meal == 'breakfast'){
        $img = url('/').'/assets/images/breakfast.jpeg';
    }
    if($meal == 'lunch'){
        $img = url('/').'/assets/images/lunch.jpeg';
    }
    if($meal == 'snacks'){
        $img = url('/').'/assets/images/snacks.jpeg';
    }
    if($meal == 'dinner'){
        $img = url('/').'/assets/images/dinner.jpeg';
    }

    if(count($getFood->images) > 0){
        foreach ($getFood->images as $image) {
            $imgs[] = url('/').'/'.$image;
        }
    } else {
        $imgs[] = $img;
    }


    $getFood->id = $food['id'];
    $getFood->name = $food['name'];
    $getFood->calories = $food['calories'];
    $getFood->protein = $food['protein'];
    $getFood->crabs = $food['crabs'];
    $getFood->fat = $food['fat'];
    $getFood->quantity = $food['quantity'];
    $getFood->serving_size = $food['serving_size'];
    $getFood->images = $imgs;
    $getFood->nutrations = $food['nutations'];
    return $getFood;
}

function get_dashboard_meals_food($food_id, $meal){
    $getFood = Food::select('id', 'name', 'images')->find($food_id);

    if($meal == 'breakfast'){
        $img = url('/').'/assets/images/breakfast.jpeg';
    }
    if($meal == 'lunch'){
        $img = url('/').'/assets/images/lunch.jpeg';
    }
    if($meal == 'snacks'){
        $img = url('/').'/assets/images/snacks.jpeg';
    }
    if($meal == 'dinner'){
        $img = url('/').'/assets/images/dinner.jpeg';
    }

    $imgs = [];
    if(count($getFood->images) > 0){
        foreach ($getFood->images as $image) {
            $imgs[] = url('/').'/'.$image;
        }
        $getFood->images = $imgs;
    } else {
        $imgs[] = $img;
        $getFood->images = $imgs;
    }


    return $getFood;
}


function uploadFile($file, $folder)
{
    $fileName = uniqid() . Carbon::now()->timestamp. '.' .$file->extension();
    $file->storeAs($folder, $fileName);

    $file_name = 'uploads/'.$folder.'/'.$fileName;
    return $file_name;
}

// Web
function admin()
{
    return Auth::guard('admin')->user();
}

function getAdminByID($id)
{
    return Admin::find($id);
}
function loadingStateSm($key, $title)
{
    $loadingSpinner = '
        <div wire:loading wire:target="' . $key . '" wire:key="' . $key . '"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> loading</div>
        <div wire:loading.remove wire:target="' . $key . '" wire:key="' . $key . '">' . $title . '</div>
    ';

    return $loadingSpinner;
}

function loadingStateXs($key, $title)
{
    $loadingSpinner = '
        <div wire:loading wire:target="' . $key . '" wire:key="' . $key . '"><span class="spinner-border spinner-border-xs align-middle" role="status" aria-hidden="true"></span></div>
        <div wire:loading.remove>' . $title . '</div>
    ';
    return $loadingSpinner;
}

function loadingStateStatus($key, $title)
{
    $loadingSpinner = '
        <div wire:loading wire:target="' . $key . '" wire:key="' . $key . '"><span class="spinner-border spinner-border-xs" role="status" aria-hidden="true"></span></div> ' . $title . '
    ';
    return $loadingSpinner;
}

function loadingStateWithText($key, $title)
{
    $loadingSpinner = '
        <div wire:loading wire:target="' . $key . '" wire:key="' . $key . '"><span class="spinner-border spinner-border-sm align-middle" role="status" aria-hidden="true"></span> </div> ' . $title . '
    ';

    return $loadingSpinner;
}

function showErrorMessage($message, $file, $line){
    if(env('APP_DEBUG') == 'true'){
        $error_array = [
            'Message' => $message,
            'File' => $file,
            'Line No' => $line
        ];
        return dd($error_array);
    }
}

