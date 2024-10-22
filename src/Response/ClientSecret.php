<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Response;

use Symfony\Component\Uid\Uuid;

final readonly class ClientSecret
{
    /**
     * @param non-empty-string $clientSecret
     */
    public function __construct(
        public Uuid $clientId,
        public string $clientSecret,
    ) {
    }
}
