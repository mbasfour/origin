<?php

use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use App\Services\ProjectService;
use App\Models\Project;

new class extends Component {
    protected $listeners = ['projectSaved' => 'refreshProjects'];

    public Collection $projects;
    public ?Project $project = null;


    public function mount(ProjectService $projectService): void
    {
        $this->fetchProjects($projectService);
    }

    public function deleteProject(int $projectId, ProjectService $projectService): void
    {
        $projectService->delete($projectId);
        $this->fetchProjects($projectService);
    }

    public function fetchProjects(ProjectService $projectService): void
    {
        $this->projects = $projectService->all();
    }

    public function addTask(int $projectId) 
    {

    }
}; ?>

<div>
    @unless ($projects->isEmpty())
        @foreach($projects as $project)
            <div class="border-b border-neutral-200 px-4 py-2 last:border-0 dark:border-neutral-700" :key="$project->id">
                <h3 class="text-lg font-medium text-blue-600">
                    {{ $project->name }}
                </h3>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $project->description }}
                </p>

                @if($project->tasks->isNotEmpty())
                    <div class="mt-2">
                        <h4 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            {{ __('Tasks') }}
                        </h4>
                        <ul class="mt-1 list-disc list-inside text-sm text-neutral-500 dark:text-neutral-400">
                            @foreach($project->tasks as $task)
                                <li>
                                    {{ $task->title }} - {{ $task->status }} -
                                    {{ $task->due_date ? $task->due_date->format('M d, Y') : __('No due date') }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <flux:button variant="primary" color="blue" type="button" size="xs" wire:click="$dispatch('editProject', { 'projectId': {{ $project->id }} })">
                    {{__('Edit')}}
                </flux:button>

                <flux:button variant="primary" color="red" type="button" size="xs" wire:click="deleteProject({{ $project->id }})">
                    {{__('Delete')}}
                </flux:button>
            </div>
        @endforeach
    @else
        <p class="p-4 text-center text-sm text-neutral-500 dark:text-neutral-400">
            {{ __('You have no projects yet.') }}
        </p>
    @endunless
</div>