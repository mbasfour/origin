<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\Repository\TaskRepositoryInterface;
use App\Models\Task;

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

    public function find($id): ?Task
    {
        return $this->taskRepository->find($id);
    }

    public function create(array $data): Task
    {
        return $this->taskRepository->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->taskRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->taskRepository->delete($id);
    }
}
