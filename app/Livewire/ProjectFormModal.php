<?php

namespace App\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use Flux\Flux;

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

    public function onEditProject(Project $project): void
    {
        if (!empty($project->id)) {
            $this->form->setProject($project);
            Flux::modal('project-form-modal')->show();
        } else {
            $this->form->reset();
        }
    }

    public function save(): void
    {
        if($this->form->id) {
            $project = Project::findOrFail($this->form->id);
            $this->authorize('update', $project);
        }
        
        $this->form->save();

        if (!$this->form->id) {
            $this->form->reset();
        }

        Flux::modal('project-form-modal')->close();

        $this->dispatch('projectSaved');
    }

    public function render()
    {
        return view('livewire.project-form-modal');
    }
}
