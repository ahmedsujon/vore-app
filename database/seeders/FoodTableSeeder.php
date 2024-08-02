<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\User;
use App\Models\UserRecentFood;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 25; $i++) {
            $user_id = User::inRandomOrder()->first()->id;
            $name = $faker->unique(true)->words($nb = 2, $asText = true);

            $food = new Food();
            $food->added_by = 'user';
            $food->user_id = $user_id;
            $food->food_unique_id = 'vore_food_' . Str::lower(Str::random(15));
            $food->name = ucwords($name);
            $food->slug = Str::slug($name);
            $food->calories = rand(20, 100);
            $food->crabs = rand(20, 100);
            $food->fat = rand(20, 100);
            $food->protein = rand(20, 100);
            $food->barcode = rand(10000000000, 99999999999);
            $food->images = [];
            $food->nutrations = [
                "dietary_fiber" => rand(5, 20),
                "total_sugars" => rand(5, 20),
                "saturated_fat" => rand(5, 20),
                "monounsaturated_fat" => rand(5, 20),
                "polyunsaturated_fat" => rand(5, 20),
                "trans_fat" => rand(5, 20),
                "cholesterol" => rand(5, 20),
                "sodium" => rand(5, 20),
                "salt" => rand(5, 20),
                "water" => rand(5, 20),
                "alcohol" => rand(5, 20),
                "vitamin_A" => rand(5, 20),
                "vitamin_B7" => rand(5, 20),
                "vitamin_C" => rand(5, 20),
                "vitamin_D" => rand(5, 20),
                "vitamin_E" => rand(5, 20),
                "vitamin_K" => rand(5, 20),
                "calcium" => rand(5, 20),
                "iron" => rand(5, 20),
                "magnesium" => rand(5, 20),
                "potassium" => rand(5, 20),
                "zinc" => rand(5, 20),
            ];
            $food->save();
        }

        // recent foods
        $foods = Food::inRandomOrder()->take(10)->get();
        foreach ($foods as $food) {
            $rec = new UserRecentFood();
            $rec->user_id = rand(1,2);
            $rec->food_id = $food->id;
            $rec->count = rand(1, 7);
            $rec->updated_at = now()->subDays(rand(1,6));
            $rec->save();
        }
    }
}
