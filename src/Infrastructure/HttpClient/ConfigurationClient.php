<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Infrastructure\HttpClient;

use Symfony\Component\Uid\Uuid;

final readonly class ConfigurationClient
{
    /**
     * @param non-empty-string $clientSecret
     * @param non-empty-string $url
     * @param non-empty-string $redirectUri
     */
    public function __construct(
        public Uuid $clientId,
        public string $clientSecret,
        public string $url,
        public string $redirectUri
    ) {
    }

    public function withClientId(Uuid $clientId): self
    {
        return new self(
            clientId: $clientId,
            clientSecret: $this->clientSecret,
            url: $this->url,
            redirectUri: $this->redirectUri,
        );
    }

    /**
     * @param non-empty-string $clientSecret
     */
    public function withClientSecret(string $clientSecret): self
    {
        return new self(
            clientId: $this->clientId,
            clientSecret: $clientSecret,
            url: $this->url,
            redirectUri: $this->redirectUri,
        );
    }

    /**
     * @param non-empty-string $url
     */
    public function withUrl(string $url): self
    {
        return new self(
            clientId: $this->clientId,
            clientSecret: $this->clientSecret,
            url: $url,
            redirectUri: $this->redirectUri,
        );
    }

    /**
     * @param non-empty-string $redirectUri
     */
    public function withRedirectUri(string $redirectUri): self
    {
        return new self(
            clientId: $this->clientId,
            clientSecret: $this->clientSecret,
            url: $this->url,
            redirectUri: $redirectUri,
        );
    }
}
