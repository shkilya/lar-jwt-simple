<?php
declare(strict_types=1);

namespace App\Utils\Auth\Models;

final class Claim
{
    public function __construct(
        private string $key,
        private mixed $value,
    )
    {
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
