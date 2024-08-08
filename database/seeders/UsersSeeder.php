<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $admin= User::create([
            'name' =>'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $teacher= User::create([
            'name' =>'teacher',
            'email' => 'teacher@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
        ]);
        $teacher->assignRole('teacher');

        $user= User::create([
            'name' =>'user',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
        ]);
        $user->assignRole('user');

    }
}
