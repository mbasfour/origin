<?php

namespace App\Interfaces\Repository;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function all(): Collection;
    public function find($id): ?Project;
    public function create(array $data): Project;
    public function update($id, array $data): bool;
    public function delete($id): bool;
}