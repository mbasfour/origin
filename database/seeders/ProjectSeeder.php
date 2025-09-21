<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        Project::insert([
            ['name' => 'Test Project 1', 'description' => 'Test project 1 description', 'user_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Test Project 2', 'description' => '', 'user_id' => 1, 'created_at' => $now, 'updated_at' => $now],

        ]);
    }
}
