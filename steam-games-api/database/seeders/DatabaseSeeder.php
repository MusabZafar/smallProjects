<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create the test user required for the UI and lab steps
        User::firstOrCreate(
            ['email' => 'pete@abc.com'],
            [
                'name' => 'Peter',
                'password' => Hash::make('qwerty1234'),
            ]
        );

        $this->call([
            GameSeederJSON::class,
        ]);
    }
}