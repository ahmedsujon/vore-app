<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emails = ["user@example.com","user01@example.com","user02@example.com","user03@example.com","user04@example.com","user05@example.com","user06@example.com","user07@example.com","user08@example.com","user09@example.com"];



        foreach($emails as $key => $email){
            $getUser = User::where('email', $email)->first();

            $faker = Faker::create();
            $name = $faker->unique(true)->words($nb=2, $asText=true);

            if(!$getUser){
                $user = new User();
                $user->name = $faker->name;
                $user->email = $email;
                $user->password = Hash::make('12345678');
                $user->avatar = 'assets/images/avatar.png';
                $user->gender = $faker->randomElement(['male', 'female']);
                $user->goal = $faker->randomElement(['Lose Weight', 'Maintain Weght', 'Build Muscle']);
                $user->daily_activity_level = $faker->randomElement(['Couch Potato', 'Lightly Active', 'Modarately Active', 'Very Active', 'Extermely Active']);
                $user->current_weight = $faker->randomElement(['70', '80', '75', '85']);
                $user->current_weight_unit = 'kg';
                $user->target_weight = $user->current_weight >= 80 ? $user->current_weight-5 : $user->current_weight+3;
                $user->target_weight_unit = 'kg';
                $user->height = $faker->randomElement(['5.6', '6.1', '5.8', '6.3']);
                $user->height_unit = 'ft';
                $user->birth_date = $faker->dateTimeBetween('1990-01-01', '2002-12-31')->format('d/m/Y');
                $user->measurements = [
                    'waist' => 0,
                    'hips' => 0,
                    'chest' => 0,
                    'thighs' => 0,
                    'upper_arms' => 0,
                ];
                $user->measurements_unit = 'in';
                $user->save();
            }
        }
    }
}
