<?php
declare(strict_types=1);

namespace App\Utils\Auth\Services;

use App\Utils\Auth\Models\Claim;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\ClaimsFormatter;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;

final class TokenGenerator
{

    public function __construct(
        private Configuration $configuration
    )
    {
    }

    public function generate(string $sub, Claim...$claims): Plain
    {
        $configuration = $this->configuration;
        $now = new \DateTimeImmutable();
        $builder = $configuration->builder();
        $builder
//            ->issuedBy('issuer')
//            ->permittedFor('subject')
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($now->modify('+1 s'));
        $configuration->setValidationConstraints(
            ...[
                new StrictValidAt(clock: SystemClock::fromSystemTimezone())
            ]
        );

        foreach ($claims as $claim) {
            $builder->withClaim($claim->getKey(), $claim->getValue());
        }
        $builder->relatedTo($sub);
        return $builder->getToken($this->configuration->signer(), $this->configuration->signingKey());
    }

}
