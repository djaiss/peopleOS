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
    protected function success(string $message, int $statusCode = 200, array $data = []): JsonResponse
    {
        $response = [
            'message' => $message,
            'status' => $statusCode,
        ];

        if ($data !== []) {
            $response['data'] = $data;
        }

        return response()->json(
            data: $response,
            status: $statusCode,
        );
    }

    /**
     * Return an error response.
     *
     * @return JsonResponse
     */
    protected function error(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }
}
