<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Throwable;

class LogService {
    public function logException(
        Throwable $exception,
        array $context = [],
    ): void {
        Log::error(
            $exception->getMessage(),
            array_merge($context, [
                'exception' => $exception::class,
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                //'trace' => $exception->getTraceAsString(),
            ]),
        );
    }
}
