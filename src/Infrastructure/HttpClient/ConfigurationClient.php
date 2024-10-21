<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Infrastructure\HttpClient;

use Symfony\Component\Uid\Uuid;

final readonly class ConfigurationClient
{
    /**
     * @param non-empty-string $url
     */
    public function __construct(
        public Uuid $clientId,
        public string $url,
    ) {
    }

    public function withClientId(Uuid $clientId): self
    {
        return new self(
            clientId: $clientId,
            url: $this->url,
        );
    }

    /**
     * @param non-empty-string $url
     */
    public function withUrl(string $url): self
    {
        return new self(
            clientId: $this->clientId,
            url: $url,
        );
    }
}
