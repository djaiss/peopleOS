<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    /**
     * Get the information about the logged user
     *
     * This endpoint gets the information about the logged user.
     *
     * @response 200 {
     *  "id": 4,
     *  "first_name": "Jessica",
     *  "last_name": "Jones",
     *  "email": "jessica.jones@gmail.com"
     * }
     */
    public function show(Request $request): JsonResponse
    {
        $response = [
            'id' => $request->user()->id,
            'first_name' => $request->user()->first_name,
            'last_name' => $request->user()->last_name,
            'email' => $request->user()->email,
        ];

        return response()->json($response);
    }
}
