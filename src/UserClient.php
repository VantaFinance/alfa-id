<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId;

use Psr\Http\Client\ClientExceptionInterface as ClientException;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\AlfaId\Response\UserInfo;
use Vanta\Integration\AlfaId\Struct\Token;
use Vanta\Integration\AlfaId\Struct\TokenType;

interface UserClient
{
    /**
     * @param Uuid                  $code         - get параметр code, из url-а, на который вернулся пользователь после авторизации в alfa-е
     * @param non-empty-string      $clientSecret
     * @param non-empty-string      $redirectUri
     * @param non-empty-string|null $codeVerifier
     *
     * @throws ClientException
     */
    public function getToken(Uuid $code, string $clientSecret, string $redirectUri, ?string $codeVerifier = null): Token;

    /**
     * @param non-empty-string $clientSecret
     *
     * @throws ClientException
     */
    public function refreshToken(Uuid $refreshToken, string $clientSecret): Token;

    /**
     * @param non-empty-string $token
     *
     * @throws ClientException
     */
    public function getUserInfo(TokenType $tokenType, string $token): UserInfo;
}
