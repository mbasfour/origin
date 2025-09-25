<?php

namespace App\Interfaces\Repository;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Task;
    public function findOrFail(int $id): Task;
    public function byProject(int $projectId): Collection;
    public function create(Project $project, array $data): Task;
    public function update(Task $task, array $data): Task;
    public function delete(Task $task): bool;
}