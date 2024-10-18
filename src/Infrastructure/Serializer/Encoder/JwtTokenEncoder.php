<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Infrastructure\Serializer\Encoder;

use JsonException;
use Symfony\Component\Serializer\Encoder\DecoderInterface as Decoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

/**
 * Запрос /api/userinfo возвращает jwt токен, который десериализуем в объект
 */
final class JwtTokenEncoder implements Decoder
{
    public const FORMAT = 'jwt-token';

    /**
     * @param array<non-empty-string|int, mixed> $context
     */
    public function decode(string $data, string $format, array $context = []): mixed
    {
        $errorMessage = sprintf('Не удалось декодировать jwt токен: %s.', $data);

        if (
            mb_strlen($data) > 0
            && [] != ($tokenParts = explode('.', $data))
            && array_key_exists(1, $tokenParts)
            && ($tokenPayload = base64_decode($tokenParts[1]))
        ) {
            try {
                return json_decode(json: $tokenPayload, associative: true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException $jsonException) {
                $errorMessage .= ' ' . $jsonException->getMessage();
            }
        }

        throw new NotEncodableValueException($errorMessage);
    }

    public function supportsDecoding(string $format): bool
    {
        return self::FORMAT === $format;
    }
}
