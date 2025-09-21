<?php

namespace App\Repositories;

use App\Interfaces\Repository\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(): Collection
    {
        return Task::with('project')->get();
    }

    public function find($id): ?Task
    {
        return Task::with('project')->find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update($id, array $data): bool
    {
        $task = Task::findOrFail($id);

        return $task->update($data);
    }

    public function delete($id): bool
    {
        $task = Task::findOrFail($id);

        return $task->delete();
    }
}