<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LinkRequest;
use App\Http\Resources\LinkResource;
use App\Repositories\LinkRepository;
use Validator;
use App\Helpers\RandomStringHelper;
use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends BaseController
{

    public function __construct(private LinkRepository $repository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $limit = \request()->get('items-per-page',10);
        $page = \request()->get('page',1);

        $links = $this->repository->list($limit, $page);

        return $this->sendResponse(
            $links->toArray(),
            'user links retrieved successfully',
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LinkRequest $request): JsonResponse
    {
        $link = $this->repository->store($request->toArray());

        return $this->sendResponse(
            [
                'original_url' => $link->original_url,
                'shortened_url' => url()->to('/') .'/'. $link->shortened_url,
                'expiration_date' => $link->expiration_date
            ],
            'Link created successfully',
            true,
            201
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Link $link
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LinkRequest $request, Link $link): JsonResponse
    {
        return $this->sendResponse(
            (array)(new LinkResource($this->repository->update($request->toArray()))),
            'Link updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Link $link
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Link $link): JsonResponse
    {
        if (!$this->repository->destroy($link)) {
            return $this->sendResponse(
                'Error',
                'Error on deleting link',
                500
            );
        }

        return $this->sendResponse([], 'Link deleted successfully');
    }
}
