<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Interfaces\Repository\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Project;

class ProjectService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProjectRepositoryInterface $projectRepository
    ) {
        //
    }

    public function all(): Collection
    {
        return $this->projectRepository->all();
    }

    public function paginate(int $limit = 10): LengthAwarePaginator
    {
        return $this->projectRepository->paginate($limit);
    }

    public function find($id): ?Project
    {
        return $this->projectRepository->find($id);
    }

    public function findOrFail($id): Project
    {
        return $this->projectRepository->findOrFail($id);
    }

    public function byUser(int $userId): Collection
    {
        return $this->projectRepository->byUser($userId);
    }

    public function byUserPaginate(int $userId, int $limit = 10): LengthAwarePaginator
    {
        return $this->projectRepository->byUserPaginate($userId, $limit);
    }

    public function create(array $data): Project
    {
        return $this->projectRepository->create($data);
    }

    public function update(Project $project, array $data): Project
    {
        return $this->projectRepository->update($project, $data);
    }

    public function delete(Project $project): bool
    {
        return $this->projectRepository->delete($project);
    }
}
