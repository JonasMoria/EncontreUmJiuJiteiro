<?php

namespace App\Http\Exceptions;

use App\Http\Enums\HttpStatusCode;
use RuntimeException;

/**
 * Utilizado para dispararar erros de validação durante o processamento
 * de dados de entrada (POST, GET etc)
 */
class FormRequestException extends RuntimeException {
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
