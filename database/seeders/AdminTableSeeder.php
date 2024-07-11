<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
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
        $getSAdmin = Admin::where('email', 'admin@voreapp.co')->first();

        if (!$getSAdmin) {
            $admin = new Admin();
            $admin->name = 'Vore Admin';
            $admin->email = 'admin@voreapp.co';
            $admin->password = Hash::make('vore@2024');
            $admin->avatar = 'assets/images/avatar.png';
            $admin->type = 'super_admin';
            $admin->permissions = json_encode(array(2, 3, 4, 5));
            $admin->save();
        }

        $getAdmin = Admin::where('email', 'developer@voreapp.co')->first();

        if (!$getAdmin) {
            $admin = new Admin();
            $admin->name = 'Developer';
            $admin->email = 'developer@voreapp.co';
            $admin->password = Hash::make('dev@vore');
            $admin->avatar = 'assets/images/avatar.png';
            $admin->type = 'admin';
            $admin->permissions = json_encode(array(1, 2, 3, 4, 5));
            $admin->added_by = '1';
            $admin->save();
        }
    }
}
