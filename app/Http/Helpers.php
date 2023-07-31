<?php

use Illuminate\Support\Facades\Auth;

function api_user(){
    return Auth::guard('user-api')->user();
}
