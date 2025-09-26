<?php

namespace App\Livewire;

use Exception;
use Illuminate\View\View;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;
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

    public function deleteProject(int $project_id): void
    {
        try {
            $project = Project::findOrFail($project_id);

            $this->authorize('delete', $project);

            $this->projectService->delete($project);

            Toaster::success('Project deleted successfully.');

            $this->loadProjects();
        } catch (AuthorizationException $e) {
            Toaster::error('You are not authorized to perform this action.');
        } catch (Exception $e) {
            Toaster::error('An error occurred while deleting the project: ' . $e->getMessage());
        }
    }

    public function deleteTask(int $task_id): void
    {
        try {
            $task = Task::findOrFail($task_id);
            
            $this->authorize('delete', $task);

            $this->taskService->delete($task);

            Toaster::success('Task deleted successfully');

            $this->loadProjects();
        } catch (AuthorizationException $e) {
            Toaster::error('You are not authorized to perform this action.');
        } catch (Exception $e) {
            Toaster::error('An error occurred while deleting the task: ' . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.projects-list')->with([
            'taskStatuses' => TaskStatusEnum::labels(),
            'projects' => $this->projectService->byUserPaginate(auth()->user()->id),
        ]);
    }
}
