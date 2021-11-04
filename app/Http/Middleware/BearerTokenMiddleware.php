<?php

namespace App\Http\Middleware;

use App\Exceptions\Http\AuthException;
use App\Utils\Auth\Services\BearerTokenValidator;
use Closure;
use Illuminate\Http\Request;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;

final class BearerTokenMiddleware
{
    public function __construct(
        private BearerTokenValidator $bearerTokenValidator
    )
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $bearerToken = $request->bearerToken();
        if(empty($request->bearerToken())){
            throw AuthException::emptyToken();
        }

        try {
            $token = $this->bearerTokenValidator->parser($bearerToken);
            $this->bearerTokenValidator->validate($token);
        }catch (RequiredConstraintsViolated $requiredConstraintsViolated) {
            throw  AuthException::invalidToken($requiredConstraintsViolated->getMessage());
        }
        return $next($request);
    }
}
