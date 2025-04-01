<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Filament\Commands\MakeUserCommand as FilamentMakeUserCommand;
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

        User::factory()->count(30)->create();
    }
}
