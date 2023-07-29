<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for($i = 1; $i <= 10; $i++) {
            $user_id = User::inRandomOrder()->first()->id;
            $name = $faker->unique(true)->words($nb=2, $asText=true);

            $food = new Food();
            $food->added_by = 'user';
            $food->user_id = $user_id;
            $food->name = ucwords($name);
            $food->slug = Str::slug($name);
            $food->quantity = rand(3,5);
            $food->serving_size = rand(3,5);
            $food->calories = rand(20,100);
            $food->crabs = rand(20,100);
            $food->fat = rand(20,100);
            $food->protein = rand(20,100);
            $food->barcode = rand(10000000000,99999999999);
            $food->image = 'assets/images/placeholder.jpg';
            $food->save();
        }
    }
}
