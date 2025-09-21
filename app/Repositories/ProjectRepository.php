<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\Repository\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all(): Collection
    {
        return Project::with('tasks')->get();
    }

    public function find($id): ?Project
    {
        return Project::with('tasks')->find($id);
    }
    public function create(array $data): Project
    {
        return auth()->user()->projects()->create($data);
    }

    public function update($id, array $data): bool
    {
        $project = Project::findOrFail($id);

        return $project->update($data);
    }

    public function delete($id): bool
    {
        $project = Project::findOrFail($id);

        return $project->delete();
    }
}