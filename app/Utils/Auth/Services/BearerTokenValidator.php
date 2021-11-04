<?php
declare(strict_types=1);

namespace App\Utils\Auth\Services;

use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\Constraint\ValidAt;

class BearerTokenValidator
{
    public function __construct(
        private Configuration $configuration
    )
    {
    }

    public function validate(Token $token): void
    {
        $this->configuration->validator()->assert($token,
            new StrictValidAt(clock: SystemClock::fromSystemTimezone()),
        );
    }

    public function parser(string $token): Token
    {
        return $this->configuration->parser()->parse($token);
    }
}
