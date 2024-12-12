<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Success response.
     *
     * @param string $message
     * @param array|object|null $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function sendResponse(int $statusCode, string $message, $data = null): JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
