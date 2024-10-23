<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

use Symfony\Component\Serializer\Annotation\SerializedPath;

final readonly class PairKey
{
    /**
     * @param non-empty-string      $accessToken
     * @param non-empty-string      $refreshToken
     * @param positive-int|null     $expiresIn
     * @param non-empty-string|null $idToken
     */
    public function __construct(
        #[SerializedPath('[access_token]')]
        public string $accessToken,
        #[SerializedPath('[refresh_token]')]
        public string $refreshToken,
        #[SerializedPath('[token_type]')]
        public TokenType $tokenType,
        #[SerializedPath('[expires_in]')]
        public ?int $expiresIn = null, // по доке, может отсутствовать
        #[SerializedPath('[id_token]')]
        public ?string $idToken = null // при обновлении токена на тестовом контуре не возвращается
    ) {
    }
}
