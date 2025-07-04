<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create Admin role and assign all permissions
        $admin = Role::create(['name' => 'Admin']);
        $teacher = Role::create(['name' => 'Teacher']);
        $student = Role::create(['name' => 'Student']);


        $permissions = Permission::pluck('id');

        $admin->givePermissionTo($permissions);
        $teacher->givePermissionTo($permissions);


    }
}
