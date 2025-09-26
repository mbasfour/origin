<?php

namespace App\Livewire;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Flux\Flux;
use App\Livewire\Forms\ProjectForm;
use App\Models\Project;


class ProjectFormModal extends Component
{
    use AuthorizesRequests;

    protected $listeners = [
        'editProject' => 'onEditProject'
    ];

    public ProjectForm $form;

    public function mount(?Project $project = null): void
    {
        if (!empty($project->id)) {
            $this->form->setProject($project);
        }
    }

    public function onModalClose(): void
    {
        $this->form->setProject(null);
        $this->form->reset();
    }

    public function onEditProject(int $project_id): void
    {
        try {
            $this->form->setProject(Project::findOrFail($project_id));

            Flux::modal('project-form-modal')->show();
        } catch (Exception $e) {
            Toaster::error('An error occurred while loading the project: ' . $e->getMessage());
        }

    }

    public function save(): void
    {
        try {
            if($this->form->id) {
                $project = Project::findOrFail($this->form->id);
                
                $this->authorize('update', $project);
            }
            
            $this->form->save();

            if (!$this->form->id) {
                $this->form->reset();
            }

            Flux::modal('project-form-modal')->close();

            Toaster::success('Project saved successfully');

            $this->dispatch('projectSaved');
        } catch (ValidationException $e) {
            Toaster::error('Please correct the errors in the form.');

            throw $e;
        } catch (AuthorizationException $e) {
            Flux::modal('project-form-modal')->close();

            Toaster::error('You are not authorized to perform this action.');
        } catch (Exception $e) {
            Flux::modal('project-form-modal')->close();

            Toaster::error('An error occurred while saving the project: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.project-form-modal');
    }
}
