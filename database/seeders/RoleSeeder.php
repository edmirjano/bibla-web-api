<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $fullAdministrator = Role::create(['name' => 'Full Administrator']);
        $songAdministrator = Role::create(['name' => 'Song Administrator']);
        $booksAdministrator = Role::create(['name' => 'Books Administrator']);
        $userMobile = Role::create(['name' => 'User Mobile']);

        // Define permissions
        $permissions = [
            'manage all books',
            'create songs',
            'view mobile content',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $fullAdministrator->syncPermissions(Permission::all()); // Full access

        $songAdministrator->syncPermissions([
            'create songs',
        ]);

        $booksAdministrator->syncPermissions([
            'manage all books',
        ]);

        $userMobile->syncPermissions([
            'view mobile content',
        ]);
    }
}
