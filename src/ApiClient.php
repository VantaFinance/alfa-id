<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId;

use Psr\Http\Client\ClientExceptionInterface as ClientException;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\AlfaId\Response\UserInfo;
use Vanta\Integration\AlfaId\Struct\Token;
use Vanta\Integration\AlfaId\Struct\TokenType;

interface ApiClient
{
    /**
     * @param non-empty-string|null $codeVerifier
     *
     * @throws ClientException
     */
    public function getToken(Uuid $code, ?string $codeVerifier = null): Token;

    /**
     * @param non-empty-string $refreshToken
     *
     * @throws ClientException
     */
    public function refreshToken(string $refreshToken): Token;

    /**
     * @param non-empty-string $token
     *
     * @throws ClientException
     */
    public function getUserInfo(TokenType $tokenType, string $token): UserInfo;
}
