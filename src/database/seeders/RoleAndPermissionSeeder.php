<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('permission.default_roles') as $role){
            Role::findOrCreate($role);
        }

        foreach (config('permission.default_permissions') as $permission){
            Permission::findOrCreate($permission);
        }
    }
}
