<?php

namespace App\Livewire;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Livewire\Forms\TaskForm;
use Flux\Flux;
use App\Models\Task;
use App\Models\Project;

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

    public function onAddTask(int $project_id): void
    {
        $this->form->reset();
        $this->form->project_id = $project_id;
        Flux::modal('task-form-modal')->show();
    }

    public function onEditTask(int $task_id): void
    {
        try {
            $this->form->setTask(Task::findOrFail($task_id));
            
            Flux::modal('task-form-modal')->show();
        } catch (Exception $e) {
            Toaster::error('An error occurred while loading the task: ' . $e->getMessage());
        }
    }

    public function save(): void
    {
        try {
            if ($this->form->id) {
                $task = Task::findOrFail($this->form->id);
                $this->authorize('update', $task);
            }

            $this->form->save();

            if (!$this->form->id) {
                $this->form->reset();
            }

            Flux::modal('task-form-modal')->close();

            Toaster::success('Task saved successfully');

            $this->dispatch('taskSaved');
        } catch (ValidationException $e) {
            Toaster::error('Please correct the errors in the form.');

            throw $e;
        } catch (AuthorizationException $e) {
            Flux::modal('task-form-modal')->close();

            Toaster::error('You are not authorized to perform this action.');
        } catch (Exception $e) {
            Flux::modal('task-form-modal')->close();
            
            Toaster::error('An error occurred while saving the task: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.task-form-modal');
    }
}
