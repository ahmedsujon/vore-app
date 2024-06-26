<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserMeasurement;
use App\Models\WaterSetting;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emails = ["user@example.com", "user01@example.com"];

        foreach ($emails as $key => $email) {
            $getUser = User::where('email', $email)->first();

            $faker = Faker::create();
            $name = $faker->unique(true)->words($nb = 2, $asText = true);

            if (!$getUser) {
                $user = new User();
                $user->name = $faker->name;
                $user->username = 'user' . rand(10, 99);
                $user->email = $email;
                $user->password = Hash::make('12345678');
                $user->avatar = 'assets/images/avatar.png';
                $user->gender = $faker->randomElement(['Male', 'Female']);
                $user->goal = $faker->randomElement(['Lose weight', 'Maintain weight', 'Build muscle']);
                $user->daily_activity_level = $faker->randomElement(['Couch Potato', 'Lightly Active', 'Moderately Active', 'Very Active', 'Extermely Active']);
                $user->current_weight = $faker->randomElement(['70', '80', '75', '85']);
                $user->current_weight_unit = 'kg';

                $user->starting_weight = $user->current_weight;
                $user->starting_weight_unit = 'kg';

                $user->target_weight = $user->current_weight >= 80 ? $user->current_weight - 5 : $user->current_weight + 3;
                $user->target_weight_unit = 'kg';
                $user->height = $faker->randomElement(['188', '160']);
                $user->height_unit = 'cm';
                $user->birth_date = $faker->dateTimeBetween('1990-01-01', '2002-12-31')->format('d/m/Y');
                $user->measurements = [
                    'waist' => 0,
                    'hips' => 0,
                    'chest' => 0,
                    'thighs' => 0,
                    'upper_arms' => 0,
                ];
                $user->measurements_unit = 'in';

                $user->calories = $faker->randomElement(['2850', '2600', '2700', '2530']);
                $user->crabs = ($user->calories * 50) / 100;
                $user->fat = ($user->calories * 30) / 100;
                $user->protein = ($user->calories * 20) / 100;

                $user->save();

                $water_setting = new WaterSetting();
                $water_setting->user_id = $user->id;
                $water_setting->pot_capacity = 8;
                $water_setting->pot_type = 'glass';
                $water_setting->goal = 80;
                $water_setting->save();

                $measurements = ["Chest", "Hips", "Waist", "Thighs", "Upper Arms", "Body Fat", "Muscle Mass"]; //"Blood Glucose", "Blood Pressure",
                $units = ["in", "in", "in", "in", "in", "%", "lbs"];
                foreach ($measurements as $key => $value) {
                    $mes = new UserMeasurement();
                    $mes->user_id = $user->id;
                    $mes->name = $value;
                    $mes->unit = $units[$key];
                    $mes->value = 0;
                    if ($key == 0) {
                        $mes->icon = 'assets/app/measurements/chest.png';
                    } else if ($key == 1) {
                        $mes->icon = 'assets/app/measurements/hips.png';
                    } else if ($key == 2) {
                        $mes->icon = 'assets/app/measurements/waist.png';
                    } else if ($key == 3) {
                        $mes->icon = 'assets/app/measurements/thigh.png';
                    } else if ($key == 4) {
                        $mes->icon = 'assets/app/measurements/muscle.png';
                    } else if ($key == 5) {
                        $mes->icon = 'assets/app/measurements/body_fat.png';
                    } else if ($key == 6) {
                        $mes->icon = 'assets/app/measurements/muscle_mass.png';
                    }
                    $mes->save();
                }
            }
        }
    }

}
