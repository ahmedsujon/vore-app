<?php

use Carbon\Carbon;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;

function api_user(){
    return Auth::guard('user-api')->user();
}

function get_meals_food($food){
    $getFood = Food::select('id', 'name', 'slug', 'nutrations', 'barcode', 'images')->find($food['food_id']);

    $imgs = [];

    if(count($getFood->images) > 0){
        foreach ($getFood->images as $image) {
            $imgs[] = url('/').'/'.$image;
        }
    } else {
        $imgs[] = url('/').'/assets/images/placeholder.jpg';
    }


    $getFood->id = $food['id'];
    $getFood->calories = $food['calories'];
    $getFood->protein = $food['protein'];
    $getFood->crabs = $food['crabs'];
    $getFood->fat = $food['fat'];
    $getFood->quantity = $food['quantity'];
    $getFood->serving_size = $food['serving_size'];
    $getFood->images = $imgs;
    return $getFood;
}

function get_dashboard_meals_food($food_id){
    $getFood = Food::select('id', 'name', 'images')->find($food_id);

    $imgs = [];
    if(count($getFood->images) > 0){
        foreach ($getFood->images as $image) {
            $imgs[] = url('/').'/'.$image;
        }
        $getFood->images = $imgs;
    } else {
        $imgs[] = url('/').'/assets/images/placeholder.jpg';
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
