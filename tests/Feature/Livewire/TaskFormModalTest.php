<?php

use App\Livewire\TaskFormModal;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Project;

it('renders successfully', function () {
    Livewire::test(TaskFormModal::class)
        ->assertStatus(200);
});

it('creates a task when the save method is called with valid data', function () {
        $user = User::factory()->create();
        $this->actingAs($user);    
    
        $project = Project::factory()->create();

        Livewire::test(TaskFormModal::class)
            ->set('form.title', 'My Test Task')
            ->set('form.status', 'todo')
            ->set('form.due_date', now()->addWeek()->toDateString())
            ->set('form.project_id', $project->id)
            ->call('save')
            ->assertDispatched('taskSaved');

        $this->assertDatabaseHas('tasks', [
            'title' => 'My Test Task',
            'status' => 'todo',
            'project_id' => $project->id,
        ]);
});

it('updates a task when the save method is called with an existing task ID', function () {
        $user = User::factory()->create();
        $this->actingAs($user);    
    
        $project = Project::factory()->for($user)->create();
        $task = $project->tasks()->create([
            'title' => 'Old Task Title',
            'status' => 'todo',
            'due_date' => now()->addDays(3),
        ]);

        Livewire::test(TaskFormModal::class, ['task' => $task])
            ->set('form.title', 'Updated Task Title')
            ->set('form.status', 'in_progress')
            ->set('form.due_date', now()->addWeek()->toDateString())
            ->call('save')
            ->assertDispatched('taskSaved');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task Title',
            'status' => 'in_progress',
        ]);
});