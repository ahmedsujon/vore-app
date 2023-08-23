<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'activity' => 'Aerobics (General)',
                'calorie' => 8
            ],
            [
                'activity' => 'Backpacking',
                'calorie' => 8
            ],
            [
                'activity' => 'Baseball',
                'calorie' => 3
            ],
            [
                'activity' => 'Basketball (Competitive)',
                'calorie' => 9
            ],
            [
                'activity' => 'Basketball (General)',
                'calorie' => 7
            ],
            [
                'activity' => 'Boxing (Competitive)',
                'calorie' => 15
            ],
            [
                'activity' => 'Boxing (Sparring)',
                'calorie' => 9
            ],
            [
                'activity' => 'Canoeing (General)',
                'calorie' => 5
            ],
            [
                'activity' => 'Climbing (General)',
                'calorie' => 7
            ],
            [
                'activity' => 'Crossfit',
                'calorie' => 9
            ],
            [
                'activity' => 'Dancing (General)',
                'calorie' => 6
            ],
            [
                'activity' => 'Football (Competitive)',
                'calorie' => 10
            ],
            [
                'activity' => 'Football (General)',
                'calorie' => 8
            ],
            [
                'activity' => 'Golf',
                'calorie' => 5
            ],
            [
                'activity' => 'Gymnastics',
                'calorie' => 4
            ],
            [
                'activity' => 'High-Intensity Interval Training (HIIT)',
                'calorie' => 9
            ],
            [
                'activity' => 'Hockey',
                'calorie' => 9
            ],
            [
                'activity' => 'Jogging',
                'calorie' => 7
            ],
            [
                'activity' => 'Kayaking',
                'calorie' => 15
            ],
            [
                'activity' => 'Martial Arts',
                'calorie' => 7
            ],
            [
                'activity' => 'Running',
                'calorie' => 12
            ],
            [
                'activity' => 'Soccer (Competitive)',
                'calorie' => 12
            ],
            [
                'activity' => 'Soccer (General)',
                'calorie' => 8
            ],
            [
                'activity' => 'Softball',
                'calorie' => 5
            ],
            [
                'activity' => 'Strength Training',
                'calorie' => 7
            ],
            [
                'activity' => 'Swimming (General)',
                'calorie' => 7
            ],
            [
                'activity' => 'Tennis (General)',
                'calorie' => 9
            ],
            [
                'activity' => 'Volleyball (Competitive)',
                'calorie' => 7
            ],
            [
                'activity' => 'Volleyball (General)',
                'calorie' => 5
            ],
            [
                'activity' => 'Walking (General)',
                'calorie' => 4
            ],
            [
                'activity' => 'Wrestling',
                'calorie' => 7
            ],
            [
                'activity' => 'Yoga',
                'calorie' => 3
            ],
            [
                'activity' => 'Zumba',
                'calorie' => 8
            ],
        ];

        foreach ($activities as $key => $value) {
            $activity = new Activity();
            $activity->name = $value['activity'];
            $activity->calories = $value['calorie'];
            $activity->status = 1;
            $activity->save();
        }
    }
}
