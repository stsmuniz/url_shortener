<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function sendResponse(
        string|array $result,
        array|string|null $message,
        bool $success = true,
        int $responseCode = 200
    ): JsonResponse
    {
        $response = [
            'success' => $success,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, $responseCode);
    }

    public function sendError(
        string|array $error,
        array|string|null $errorMessages,
        int $code = 400): JsonResponse
    {
        return $this->sendResponse($errorMessages, $error, false, $code);
    }
}
