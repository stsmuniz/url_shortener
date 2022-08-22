<?php

namespace App\Repositories;

use App\Helpers\RandomStringHelper;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class LinkRepository implements RepositoryInterface
{
    public function __construct(private Link $link)
    {
    }

    public function list(int $itemsPerPage, int $page): Collection
    {
        $skip = $itemsPerPage * ($page - 1);

        $userLinks = auth()->user()->links()
            ->skip($skip)
            ->take($itemsPerPage)
            ->get();

        return $userLinks->map(fn($link) => new LinkResource($link));
    }

    public function store(array $data): Link
    {
        $this->link->original_url = $data['original_url'];
        $this->link->shortened_url = $data['shortened_url'] ?? RandomStringHelper::generate();
        $this->link->active = true;
        $this->link->user_id = auth()->user()->id;
        $this->link->save();

        return $this->link;
    }

    public function update(array $data): Link
    {
        $this->link->originalUrl = $data['original_url'];
        $this->link->shortened_url = $input['shortened_url'] ?? RandomStringHelper::generate();
        $this->link->active = true;
        $this->link->user = auth()->user();
        $this->link->save();

        return $this->link;
    }

    public function destroy(Model $link): bool|null
    {
        return $link->delete();
    }
}
