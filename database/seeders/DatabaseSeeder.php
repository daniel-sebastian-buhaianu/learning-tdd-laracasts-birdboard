<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::factory()->create([
            'name' => 'Daniel',
            'email' => 'dsb99.dev@gmail.com',
        ]);

        $project = Project::factory()->create([
            'owner_id' => $user,
            'title' => 'Teamwork Project',
            'description' => 'Cool project working in a team.'
        ]);

        Task::factory(3)->create([
            'project_id' => $project
        ]);
        
        $testUser = User::factory()->create([
            'name' => 'Test',
            'email' => 'test@test.com'
        ]);

        $project->invite($testUser);
    }
}
