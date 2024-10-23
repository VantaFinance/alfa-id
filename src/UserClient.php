<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId;

use Psr\Http\Client\ClientExceptionInterface as ClientException;
use Vanta\Integration\AlfaId\Response\UserInfo;
use Vanta\Integration\AlfaId\Struct\PairKey;

interface UserClient
{
    /**
     * @param non-empty-string      $code         - get параметр code, из url-а, на который вернулся пользователь после авторизации в alfa-е
     * @param non-empty-string      $redirectUri
     * @param non-empty-string|null $codeVerifier
     *
     * @throws ClientException
     */
    public function getPairKeyByAuthorizationCode(string $code, string $redirectUri, ?string $codeVerifier = null): PairKey;

    /**
     * @param non-empty-string $refreshToken
     *
     * @throws ClientException
     */
    public function getPairKeyByRefreshToken(string $refreshToken): PairKey;

    /**
     * @param non-empty-string $token
     *
     * @throws ClientException
     */
    public function getUserInfo(string $token): UserInfo;
}
