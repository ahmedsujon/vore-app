<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emails = ['admin@voreapp.com', 'admin@example.com'];

        foreach ($emails as $key => $email) {
            $getSAdmin = Admin::where('email', )->first();
            if (!$getSAdmin) {
                $admin = new Admin();
                $admin->name = $key == 0 ? 'Vore Admin' : 'Developer';
                $admin->email = $email;
                $admin->password = $key == 0 ? Hash::make('vore@2024') : Hash::make('12345678');
                $admin->avatar = 'assets/images/avatar.png';
                $admin->save();
            }
        }
    }
}
