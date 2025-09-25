<?php

namespace App\Livewire;

use Illuminate\View\View;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\ProjectService;
use App\Services\TaskService;
use App\Models\Project;
use App\Models\Task;
use App\Enums\TaskStatusEnum;

class ProjectsList extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    protected $listeners = [
        'projectSaved' => 'loadProjects',
        'taskSaved' => 'loadProjects'
    ];

    //public LengthAwarePaginator $projects;

    protected ProjectService $projectService;

    protected TaskService $taskService;

    public function boot(): void
    {
        $this->projectService = app(ProjectService::class);
        $this->taskService = app(TaskService::class);
    }

    public function loadProjects(): void
    {
        $this->dispatch('$refresh');
        //$this->projects = $this->projectService->byUserPaginate(auth()->user()->id);
    }

    public function deleteProject(Project $project): void
    {
        $this->authorize('delete', $project);

        $this->projectService->delete($project);

        $this->loadProjects();
    }

    public function deleteTask(Task $task): void
    {
        $this->authorize('delete', $task);

        $this->taskService->delete($task);

        $this->loadProjects();
    }

    public function render(): View
    {
        return view('livewire.projects-list')->with([
            'taskStatuses' => TaskStatusEnum::labels(),
            'projects' => $this->projectService->byUserPaginate(auth()->user()->id),
        ]);
    }
}
