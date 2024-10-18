<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Infrastructure\HttpClient\Exception;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ForbiddenException extends AlfaIdException
{
    public static function create(Response $response, Request $request): self
    {
        return new self($response, $request, 'Forbidden');
    }
}
