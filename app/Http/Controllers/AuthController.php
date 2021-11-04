<?php
declare(strict_types=1);

namespace App\Http\Controllers;


use App\Http\Middleware\BearerTokenMiddleware;
use App\Utils\Auth\Models\Claim;
use App\Utils\Auth\Services\BearerTokenValidator;
use App\Utils\Auth\Services\TokenGenerator;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;

#[Middleware('api')]
class AuthController
{
    public function __construct(
        private TokenGenerator $tokenGenerator,
        private BearerTokenValidator $bearerTokenValidator

    )
    {}

    #[Get(uri: '/auth',name: 'auth')]
    public function index()
    {
        $claims = [
            new Claim('roles','ROLE_ADMIN'),
            new Claim('pas','test'),
        ];
        return response()->json($this->tokenGenerator->generate('6',...$claims)->toString());
        die;
        return $this->tokenGenerator->generate('5',...$claims);
    }

    #[Get(uri: '/auth/val',name: 'auth.val',middleware: [BearerTokenMiddleware::class])]
    public function val()
    {
        $r = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6IlJPTEVfQURNSU4iLCJzdWIiOiI1IiwiZXhwIjoxNjM1MzM2OTA5LjgzNDI1Nn0.ETvdETFGQ-xNu8yiGT1oCi75jMAHnxJxmgM9CRqnmQjTAsHcuQjSwldV7kZ-6mH08wT9SlfODFvD7iavLtrpSLHNoiw1J2YuF5hdmd6DjKXPp5K8auEJB_d_RRn9zNJXssov9EvQAF5OlLQ_CMvJosbELtkMvX-FXkeJH-zJUhCpW-Yfxd5zyXE7kZ0Eid4g_uxi7UOSALRZQ3CasGLNfwSPxMUFZSXK_fJy3QzhoLWiIx7oFEUAjok0KnGNxvNLQGiWahhC3_MlZps15_umioMxnDk__8AbvRCiUkGIcr-oHmudK8t2Tej4eahif0SaEe0OvPKh4fYj7ZJbPEjc68l1ML1fqsPb-FKHMcPnWJXbLUIRPgvu36Fx6fwouXg4UyqECwm5mE3dox74jQe3dtNZXhvxnDXeuA_eoYikOPXWddlY1XaZ7zVO7B8kXS2BPcxdlAek9hdvoVFDlNo6vW61I233JsTkIlg-P2mkDkymiGrub6lIhsABpzhMwJfIvT64qdZa9Ymr7yerAp-I_zr-KRSbh8ezMPL8e6pKL9mFLq86OuJTs4eS02dMDbN4s1KP-FaC1ilSiHbCvuuris-0VFQlD-XWPGc2d445EelIakPUUnGtjEqHOGqFanw7fsa4Nz5gboNvynJVV1PKFQ2XFC90WZftbDuZlEW6MNY';
        $token = $this->bearerTokenValidator->parser($r);
        return $this->bearerTokenValidator->validate($token);
    }

}
