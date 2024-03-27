<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ["users_manage", "admins_manage", "settings_manage","profile_update"];

        foreach ($permissions as $key => $permission) {
            $getData = Permission::where('value', $permission)->first();

            if (!$getData) {
                $data = new Permission();
                $data->name = ucwords(str_replace('_', ' ', $permission));
                $data->value = $permission;
                $data->save();
            }
        }
    }
}
