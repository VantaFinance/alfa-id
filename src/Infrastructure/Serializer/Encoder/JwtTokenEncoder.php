<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Infrastructure\Serializer\Encoder;

use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Symfony\Component\Serializer\Encoder\DecoderInterface as Decoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

use function Vanta\Integration\AlfaId\Response\underscoreToCamelCase;

/**
 * Запрос /api/userinfo возвращает jwt токен, который десериализуем в объект
 */
final readonly class JwtTokenEncoder implements Decoder
{
    public const FORMAT = 'jwt-token';

    public function __construct(
        private Parser $jwtParser = new Parser(new JoseEncoder())
    ) {
    }

    /**
     * @param non-empty-string                   $data
     * @param non-empty-string                   $format
     * @param array<non-empty-string|int, mixed> $context
     *
     * @return non-empty-array<non-empty-string, mixed>
     */
    public function decode(string $data, string $format, array $context = []): array
    {
        try {
            /** @var Plain $tokenParsed */
            $tokenParsed = $this->jwtParser->parse($data);
        } catch (CannotDecodeContent|InvalidTokenStructure|UnsupportedHeaderFound $exception) {
            throw new UnexpectedValueException(
                message: sprintf('Не удалось декодировать jwt токен: %s, ошибка: %s', $data, $exception->getMessage()),
                previous: $exception,
            );
        }

        $jwtParsedData = $tokenParsed->claims()->all();

        if ([] == $jwtParsedData) {
            throw new UnexpectedValueException(message: sprintf('Не удалось декодировать jwt токен: %s, ошибка: данные пусты', $data));
        }

        /** @var array<int|non-empty-string, array<int|non-empty-string, non-empty-string>|scalar> $dataDeserialized */
        $dataDeserialized = [];

        foreach ($jwtParsedData as $key => $value) {
            $dataDeserialized[underscoreToCamelCase($key)] = $value;
        }

        $dataDeserialized['aud'] = $dataDeserialized['aud'][0] ?? null; // по документации поле - Uuid, но API возвращает массив с единственным элементом Uuid

        $dataDeserialized['identityDocumentSeries'] = array_key_exists('identityDocumentSeries', $dataDeserialized)
            ? str_replace(' ', '', $dataDeserialized['identityDocumentSeries']) // API возвращает с пробелом посередине
            : null
        ;

        $dataDeserialized['rawValue'] = json_encode($data, JSON_UNESCAPED_UNICODE);

        return $dataDeserialized;

    }

    /**
     * @param non-empty-string $format
     */
    public function supportsDecoding(string $format): bool
    {
        return self::FORMAT === $format;
    }
}
