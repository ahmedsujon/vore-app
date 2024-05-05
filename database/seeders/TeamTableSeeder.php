<?php

namespace Database\Seeders;

use App\Models\Team;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            Team::create([
                'name' => $faker->name,
                'designation' => $faker->word(),
                'image' => 'assets/images/avatar.png',
            ]);
        }
    }
}
