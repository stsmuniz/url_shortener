<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Link;

interface RepositoryInterface
{
    public function store(array $array): Model;
    public function update(array $array): Model;
    public function destroy(Model $model): bool|null;
}
