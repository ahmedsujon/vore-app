<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function foods(Request $request)
    {
        $pagination_value = $request->per_page ? $request->per_page : 10;
        $foods = Food::where('status', 1)->paginate($pagination_value);

        return response()->json($foods);
    }
}
