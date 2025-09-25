<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Interfaces\Repository\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all(): Collection
    {
        return Project::with('tasks')->get();
    }

    public function paginate(int $limit = 10): LengthAwarePaginator
    {
        return Project::with('tasks')->paginate($limit);
    }
    public function find(int $id): ?Project
    {
        return Project::with('tasks')->find($id);
    }

    public function findOrFail(int $id): Project
    {
        return Project::with('tasks')->findOrFail($id);
    }

    public function byUser(int $userId): Collection
    {
        return Project::with('tasks')->whereUserId($userId)->get();
    }

    public function byUserPaginate(int $userId, int $limit = 10): LengthAwarePaginator
    {
        return Project::with('tasks')->whereUserId($userId)->paginate($limit);
    }

    public function create(array $data): Project
    {
        return auth()->user()->projects()->create($data);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);

        return $project;
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }
}