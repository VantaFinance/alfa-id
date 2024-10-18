<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

use Symfony\Component\Uid\Uuid;

final readonly class Token
{
    /**
     * @param non-empty-string      $accessToken
     * @param positive-int|null     $expiresIn
     * @param non-empty-string|null $idToken
     */
    public function __construct(
        public string $accessToken,
        public Uuid $refreshToken,
        public TokenType $tokenType,
        public ?int $expiresIn = null, // по доке, может отсутствовать
        public ?string $idToken = null // при обновлении токена на тестовом контуре не возвращается
    ) {
    }
}
