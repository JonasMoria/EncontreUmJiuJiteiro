<?php

namespace App\Http\Traits;

use App\Http\Enums\HttpStatusCode;
use Illuminate\Http\JsonResponse;

trait HttpResponse {
    public static function makeResponse(
        string $message,
        HttpStatusCode $httpCode,
        array $data = []
    ): JsonResponse {
        return response()->json(
            [
                'message' => $message,
                'data' => $data,
            ],
            $httpCode->value
        );
    }
}
