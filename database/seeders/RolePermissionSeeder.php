<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'manage-roles']);
        Permission::create(['name' => 'manage-permissions']);
        Permission::create(['name' => 'manage-posts']);
        Permission::create(['name' => 'manage-telescope']);
        Role::create(['name' => 'super-admin'])->givePermissionTo([
           'manage-users','manage-roles','manage-permissions','manage-posts','manage-telescope'
        ]);
        Role::create(['name' => 'admin'])->givePermissionTo([
            'manage-users','manage-permissions','manage-posts','manage-telescope'
        ]);
        Role::create(['name' => 'teacher'])->givePermissionTo([
         'manage-posts',
        ]);
        Role::create(['name' => 'user']);
    }
}
