<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as PsrHttpClient;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\ConfigurationClient;

final readonly class PipelineMiddleware
{
    /**
     * @param array<int, Middleware> $middlewares
     */
    public function __construct(
        private array $middlewares,
        private PsrHttpClient $client
    ) {
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function process(Request $request, ConfigurationClient $configuration): Response
    {
        $middlewares = $this->middlewares;
        $middleware  = array_shift($middlewares);

        if (null == $middleware) {
            return $this->client->sendRequest($request);
        }

        return $middleware->process($request, $configuration, [new self($middlewares, $this->client), 'process']);
    }
}
