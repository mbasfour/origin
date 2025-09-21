<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        Task::insert([
            ['title' => 'Task 1 for Project 1', 'status' => 'todo', 'project_id' => 1, 'due_date' => $now->addDays(7), 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Task 2 for Project 1', 'status' => 'in_progress', 'project_id' => 1, 'due_date' => $now->addDays(14), 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
