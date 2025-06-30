<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    /**
     * Return a 200 OK response.
     *
     * @return JsonResponse
     */
    protected function ok(string $message): JsonResponse
    {
        return $this->success($message, 200);
    }

    /**
     * Return a success response.
     *
     * @return JsonResponse
     */
    protected function success(string $message, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }
}
