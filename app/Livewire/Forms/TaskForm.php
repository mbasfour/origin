<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Task;
use App\Models\Project;
use App\Services\TaskService;

class TaskForm extends Form
{
    public ?int $id = null;

    # [Validate(required|string|max:255)]
    public string $title = '';

    # [Validate(required|in:todo,in_progress,done)]
    public string $status = 'todo';

    # [Validate(nullable|date)]
    public string $due_date = '';

    # [Validate(required|integer|exists:projects,id)]
    public ?int $project_id = null;

    protected TaskService $service;

    public function boot(): void
    {
        $this->service = app(TaskService::class);
    }

    public function setTask(?Task $task): void 
    {
        if($task) {
            $this->id = $task->id;
            $this->title = $task->title;
            $this->status = $task->status;
            $this->due_date = $task->due_date;
            $this->project_id = $task->project_id;
        }
    }

    public function save(): Task {
        if(!$this->id) {
            $project = Project::findOrFail($this->project_id);

            return $this->service->create($project, [
                'title' => $this->title,
                'status' => $this->status,
                'due_date' => $this->due_date
            ]);
        } else {
            $task = $this->service->findOrFail($this->id);

            return $this->service->update($task, [
                'title' => $this->title,
                'status' => $this->status,
                'due_date' => $this->due_date
            ]);
        }
    }

}
