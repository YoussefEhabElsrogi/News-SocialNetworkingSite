<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RelatedNewsResource;
use App\Models\RelatedNewsSite;
use App\Traits\ApiResponseTrait;

class RelatedNewsController extends Controller
{
    use ApiResponseTrait;
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $relatedNews = RelatedNewsSite::get();

        if (!$relatedNews) {
            return ApiResponseTrait::sendResponse(404, 'Related News Empty', null);
        }

        $relatedNewsResource = RelatedNewsResource::collection($relatedNews);

        return ApiResponseTrait::sendResponse(200, 'Related News', $relatedNewsResource);
    }
}
