<?php
declare(strict_types=1);

namespace App\Exceptions\Http;

use Exception;
use Throwable;

class AuthException extends Exception
{
    private int $httpStatusCode;

    public function __construct($message = "", $code = 0, int $httpStatusCode = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->httpStatusCode = $httpStatusCode;
    }

    public static function invalidToken(?string $message = 'Invalid token'): static
    {
        return new static(
            message: $message,
            code: 400,
            httpStatusCode: 400
        );
    }

    public static function emptyToken(): static
    {
        return new static(
            message: 'Empty token',
            code: 400,
            httpStatusCode: 400
        );
    }

}

