<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\Repository\TaskRepositoryInterface;
use App\Models\Task;
use App\Models\Project;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected TaskRepositoryInterface $taskRepository
    ) {
        //
    }

    public function all(): Collection
    {
        return $this->taskRepository->all();
    }

    public function find(int $id): ?Task
    {
        return $this->taskRepository->find($id);
    }

    public function findOrFail(int $id): Task
    {
        return $this->taskRepository->findOrFail($id);
    }

    public function byProject(int $projectId): Collection
    {
        return $this->taskRepository->byProject($projectId);
    }

    public function create(Project $project, array $data): Task
    {
        return $this->taskRepository->create($project, $data);
    }

    public function update(Task $task, array $data): Task
    {
        return $this->taskRepository->update($task, $data);
    }

    public function delete(Task $task): bool
    {
        return $this->taskRepository->delete($task);
    }
}
