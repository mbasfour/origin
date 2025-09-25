<?php

namespace App\Repositories;

use App\Interfaces\Repository\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Task;
use App\Models\Project;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(): Collection
    {
        return Task::with('project')->get();
    }

    public function find(int $id): ?Task
    {
        return Task::with('project')->find($id);
    }

    public function findOrFail(int $id): Task
    {
        return Task::with('project')->findOrFail($id);
    }

    public function byProject(int $projectId): Collection
    {
        return Task::with('project')->whereProjectId($projectId)->get();
    }

    public function create(Project $project, array $data): Task
    {
        return $project->tasks()->create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        return $task;
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}