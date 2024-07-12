<?php

namespace App\Exceptions;

use Throwable;

class PageNotFoundException extends HttpException
{
    public function __construct(
        string $message = "Страница не найдена",
        int $code = 404,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
