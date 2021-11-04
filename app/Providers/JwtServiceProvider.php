<?php

namespace App\Providers;

use App\Utils\Auth\Services\TokenGenerator;
use Illuminate\Support\ServiceProvider;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key\InMemory;

class JwtServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Configuration::class, function ($app): Configuration {
            $configuration  = Configuration::forAsymmetricSigner(
                signer: new Signer\Rsa\Sha256(),
                signingKey: InMemory::file(config('jwt.jwt_private_key_path')),
                verificationKey: InMemory::file(config('jwt.jwt_public_key_path')),
            );
            $now = new \DateTimeImmutable();
            return $configuration;
        });

        $this->app->singleton(TokenGenerator::class, function ($app): TokenGenerator {
            return new TokenGenerator(
                $app->make(Configuration::class),
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
