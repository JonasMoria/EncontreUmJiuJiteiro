<?php

namespace App\Http\Exceptions;

use App\Http\Enums\HttpStatusCode;
use RuntimeException;

/**
 * Utilizado para disparar erros personalizados nas camadas posteriores ao
 * Controller
 */
class AppRuntimeException extends RuntimeException {
    public function __construct(
        string $message,
        ?HttpStatusCode $code = null,
    ) {
        parent::__construct(
            $message,
            $code != null
                ? $code->value
                : HttpStatusCode::UNPROCESSABLE_ENTITY->value,
        );
    }
}
