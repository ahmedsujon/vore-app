<?php

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
