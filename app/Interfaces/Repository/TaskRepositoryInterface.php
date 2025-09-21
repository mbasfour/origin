<?php

namespace App\Interfaces\Repository;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function all(): Collection;
    public function find($id): ?Task;
    public function create(array $data): Task;
    public function update($id, array $data): bool;
    public function delete($id): bool;
}