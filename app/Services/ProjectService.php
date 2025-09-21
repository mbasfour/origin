<?php

namespace App\Services;

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

    public function find($id): ?Project
    {
        return $this->projectRepository->find($id);
    }

    public function create(array $data): Project
    {
        return $this->projectRepository->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->projectRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->projectRepository->delete($id);
    }
}
