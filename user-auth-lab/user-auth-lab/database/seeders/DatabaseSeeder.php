<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the main demo user
        $demoUser = User::create([
            'first_name' => 'John',
            'last_name' => 'Demo',
            'name' => 'John Demo',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create an employer owned by this user
        $demoEmployer = \App\Models\Employer::create([
            'name' => 'Johns Tech Corp',
            'user_id' => $demoUser->id,
        ]);

        // Create multiple jobs for that employer
        \App\Models\Job::create([
            'employer_id' => $demoEmployer->id,
            'title' => 'Senior Laravel Developer',
            'salary' => '$120,000 USD',
        ]);

        \App\Models\Job::create([
            'employer_id' => $demoEmployer->id,
            'title' => 'Full Stack Engineer',
            'salary' => '$95,000 USD',
        ]);

        // Create additional users/employers/jobs so authorization can be tested
        $otherUser = User::create([
            'first_name' => 'Jane',
            'last_name' => 'Tester',
            'name' => 'Jane Tester',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        $otherEmployer = \App\Models\Employer::create([
            'name' => 'Testers LLC',
            'user_id' => $otherUser->id,
        ]);

        \App\Models\Job::create([
            'employer_id' => $otherEmployer->id,
            'title' => 'QA Automation Lead',
            'salary' => '$110,000 USD',
        ]);

        \App\Models\Job::create([
            'employer_id' => $otherEmployer->id,
            'title' => 'Junior Web Developer',
            'salary' => '$60,000 USD',
        ]);
    }
}
