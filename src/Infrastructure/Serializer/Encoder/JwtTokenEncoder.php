<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Infrastructure\Serializer\Encoder;

use JsonException;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Symfony\Component\Serializer\Encoder\DecoderInterface as Decoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Vanta\Integration\AlfaId\Struct\Token;
use function Vanta\Integration\AlfaId\Response\underscoreToCamelCase;

/**
 * Запрос /api/userinfo возвращает jwt токен, который десериализуем в объект
 */
final class JwtTokenEncoder implements Decoder
{
    public const FORMAT = 'jwt-token';

    public function __construct(
        private Parser $jwtParser = new Parser(new JoseEncoder())
    ) {
    }

    /**
     * @param array<non-empty-string|int, mixed> $context
     * @return non-empty-array<non-empty-string, mixed>
     */
    public function decode(string $data, string $format, array $context = []): array
    {
        try {
            $jwtParsedData = $this->jwtParser->parse($data)->claims()->all();
        } catch (CannotDecodeContent|InvalidTokenStructure|UnsupportedHeaderFound $exception) {
            throw new UnexpectedValueException(
                message: sprintf('Не удалось декодировать jwt токен: %s, ошибка: %s', $data, $exception->getMessage()),
                previous: $exception,
            );
        }

        if ([] == $jwtParsedData) {
            throw new UnexpectedValueException(message: sprintf('Не удалось декодировать jwt токен: %s, ошибка: данные пусты', $data));
        }

        $dataDeserialized = [];

        foreach ($jwtParsedData as $key => $value) {
            $dataDeserialized[underscoreToCamelCase($key)] = $value;
        }

        $dataDeserialized['rawValue'] = $data;

        $dataDeserialized['aud'] = $dataDeserialized['aud'][0] ?? null; // по документации поле - Uuid, но API возвращает массив с единственным элементом Uuid

        $dataDeserialized['identityDocumentSeries'] = array_key_exists('identityDocumentSeries', $dataDeserialized)
            ? str_replace(' ', '', $dataDeserialized['identityDocumentSeries']) // API возвращает с пробелом посередине
            : null
        ;

        return $dataDeserialized;

    }

    public function supportsDecoding(string $format): bool
    {
        return self::FORMAT === $format;
    }
}
