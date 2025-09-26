<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Project;
use App\Services\ProjectService;

class ProjectForm extends Form
{
    public ?int $id = null;

    #[Validate('required|string|max:255')]
    public string $name = '';
    
    #[Validate('nullable|string')]
    public string $description = '';

    protected ProjectService $service;

    public function boot(): void
    {
        $this->service = app(ProjectService::class);
    }

    public function setProject(?Project $project): void 
    {
        if($project) {
            $this->id = $project->id;
            $this->name = $project->name;
            $this->description = $project->description;
        }
    }

    public function save(): Project {
        $this->validate();
        
        if(!$this->id) {
            return $this->service->create([
                'name' => $this->name,
                'description' => $this->description
            ]);
        } else {
            $project = $this->service->findOrFail($this->id);

            return $this->service->update($project, [
                'name' => $this->name,
                'description' => $this->description
            ]);
        }
    }
}