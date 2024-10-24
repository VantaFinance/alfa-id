<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Transport;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface as HttpClient;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\AlfaId\AuthClient;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\ConfigurationClient;
use Vanta\Integration\AlfaId\Response\ClientSecret;
use Yiisoft\Http\Method;

final readonly class RestAuthClient implements AuthClient
{
    public function __construct(
        private Serializer $serializer,
        private HttpClient $client,
        private ConfigurationClient $configurationClient,
    ) {
    }

    public function getClientSecret(): ClientSecret
    {
        $request = new Request(
            Method::POST,
            sprintf('/oidc/clients/%s/client-secret', $this->configurationClient->clientId->jsonSerialize()),
            ['Accept' => 'application/json'],
        );

        $response = $this->client->sendRequest($request)->getBody()->__toString();

        return $this->serializer->deserialize($response, ClientSecret::class, 'json');
    }
}
