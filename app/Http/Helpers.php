<?php

use Carbon\Carbon;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;

function api_user(){
    return Auth::guard('user-api')->user();
}

function get_meals_food($food){
    $getFood = Food::select('id', 'name', 'slug', 'calories', 'protein', 'crabs', 'fat', 'barcode', 'image')->find($food['id']);
    $getFood->image = url('/').'/'.$getFood->image;
    $getFood->quantity = $food['quantity'];
    $getFood->serving_size = $food['serving_size'];
    return $getFood;
}


function uploadFile($file, $folder)
{
    $fileName = uniqid() . Carbon::now()->timestamp. '.' .$file->extension();
    $file->storeAs($folder, $fileName);

    $file_name = 'uploads/'.$folder.'/'.$fileName;
    return $file_name;
}
