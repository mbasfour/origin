<?php

namespace App\Interfaces\Repository;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    public function all(): Collection;
    public function paginate(int $limit = 10): LengthAwarePaginator;
    public function find(int $id): ?Project;
    public function findOrFail(int $id): Project;
    public function byUser(int $userId): Collection;
    public function byUserPaginate(int $userId, int $limit = 10): LengthAwarePaginator;
    public function create(array $data): Project;
    public function update(Project $project, array $data): Project;
    public function delete(Project $project): bool;
}