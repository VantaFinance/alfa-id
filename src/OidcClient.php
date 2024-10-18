<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId;

use Psr\Http\Client\ClientExceptionInterface as ClientException;
use Vanta\Integration\AlfaId\Response\ClientSecret;

interface OidcClient
{
    /**
     * @throws ClientException
     */
    public function getClientSecret(): ClientSecret;
}
