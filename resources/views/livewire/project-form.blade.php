<?php

use Livewire\Volt\Component;
use App\Services\ProjectService;
use App\Models\Project;
use Illuminate\Validation\ValidationException;

new class extends Component {
    protected $listeners = ['editProject' => 'loadProject'];


    public ?Project $project = null;
    public string $name = '';
    public string $description = '';

    public function mount(?Project $project = null): void
    {
        if (!empty($project->id)) {
            $this->project  = $project;
            $this->name   = $project->name;
            $this->description = $project->description;
        }
    }

    public function loadProject(int $projectId): void
    {
        $this->project  = Project::findOrFail($projectId);
        $this->name   = $this->project->name;
        $this->description = $this->project->description;
    }

    public function save(ProjectService $projectService): void
    {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            $this->reset('name', 'description');

            throw $e;
        }

        if(!$this->project) {
            $projectService->create([
                'name' => $validated['name'],
                'description' => $validated['description']
            ]);
        } else {
            $projectService->update($this->project->id, [
                'name' => $validated['name'],
                'description' => $validated['description']
            ]);
        }

        // Reset form fields
        $this->reset('name', 'description');

        // Optionally, you can emit an event or flash a message
        $this->dispatch('projectSaved');
    }
}; ?>

<div>
    <div class="mt-3 p-3">
        <form method="project" wire:submit.prevent="save" class="mt-6 space-y-6">
            <flux:input wire:model="name" :label="__('Project Name')" type="text" required autocomplete="name" />
            <flux:textarea wire:model="description" :label="__('Project Description')" rows="auto" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="save-project-button">
                        {{ !$project ? __('Save') : __('Update') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="project-saved">
                    {{ !$project ? __('Saved.') : __('Updated.') }}
                </x-action-message>
            </div>
        </form>
    </div>
</div>