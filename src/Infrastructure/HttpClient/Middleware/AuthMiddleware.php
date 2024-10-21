<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware;

use Nyholm\Psr7\Stream;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanta\Integration\AlfaId\AuthClient;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\ConfigurationClient;

final readonly class AuthMiddleware implements Middleware
{
    public function __construct(
        private AuthClient $authClient
    ) {
    }

    public function process(Request $request, ConfigurationClient $configuration, callable $next): Response
    {
        if ('/api/token' != $request->getUri()) {
            return $next($request, $configuration);
        }

        $clientSecret = $this->authClient->getClientSecret();

        parse_str($request->getBody()->getContents(), $requestData);

        $requestData['client_secret'] = $clientSecret->clientSecret;

        $request = $request->withBody(Stream::create(http_build_query($requestData)));

        return $next($request, $configuration);
    }
}
