<?php

namespace App\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use App\Models\Project;
use Flux\Flux;

class TaskFormModal extends Component
{
    use AuthorizesRequests;

    protected $listeners = [
        'addTask' => 'onAddTask',
        'editTask' => 'onEditTask'
    ];

    public TaskForm $form;

    public function mount(?Task $task = null): void
    {
        if (!empty($task->id)) {
            $this->form->setTask($task);
        }
    }

    public function onModalClose(): void
    {
        $this->form->setTask(null);
        $this->form->reset();
    }

    public function onAddTask(Project $project): void
    {
        $this->form->reset();
        $this->form->project_id = $project->id;
        Flux::modal('task-form-modal')->show();
    }

    public function onEditTask(Task $task): void
    {
        if (!empty($task->id)) {
            $this->form->setTask($task);
            Flux::modal('task-form-modal')->show();
        } else {
            $this->form->reset();
        }
    }

    public function save(): void
    {
        if($this->form->id) {
            $task = Task::findOrFail($this->form->id);
            $this->authorize('update', $task);
        }

        $this->form->save();

        if (!$this->form->id) {
            $this->form->reset();
        }

        Flux::modal('task-form-modal')->close();

        $this->dispatch('taskSaved');
    }
    
    public function render()
    {
        return view('livewire.task-form-modal');
    }
}
