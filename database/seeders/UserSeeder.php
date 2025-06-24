<?php

namespace Database\Seeders;

use Filament\Commands\MakeUserCommand as FilamentMakeUserCommand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filamentMakeUserCommand = new FilamentMakeUserCommand();
        $reflector               = new \ReflectionObject($filamentMakeUserCommand);

        $getUserModel = $reflector->getMethod('getUserModel');

        $getUserModel->setAccessible(true);

        $admin = $getUserModel->invoke($filamentMakeUserCommand)::create([
            'name'           => 'ADMIN',
            'email'          => 'admin@admin.com',
            'password'       => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole('Admin');

        $teacher = $getUserModel->invoke($filamentMakeUserCommand)::create([
            'name'           => 'Marios Panagi',
            'email'          => 'mpanagi97@gmail.com',
            'password'       => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $teacher->assignRole('Teacher');


        $testStudent = $getUserModel->invoke($filamentMakeUserCommand)::create([
            'name'           => 'Stelios Chrysostomou',
            'email'          => 'stelioschrysost@gmail.com',
            'password'       => Hash::make('password'),
            'remember_token' => Str::random(10),
            'grade_level'    => 'C',
        ]);

        $testStudent->assignRole('Student');
    }
}
