<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Infrastructure\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\DecoderInterface as Decoder;
use Symfony\Component\Serializer\Encoder\EncoderInterface as Encoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder as JsonEncoderSymfony;

use function Vanta\Integration\AlfaId\Response\arrayReplaceValueRecursive;

final class JsonEncoder implements Encoder, Decoder
{
    public function __construct(
        private JsonEncoderSymfony $jsonEncoder,
    ) {
    }

    /**
     * @param non-empty-string         $format
     * @param array<int|string, mixed> $context
     */
    public function encode(mixed $data, string $format, array $context = []): string
    {
        return $this->jsonEncoder->encode($data, $format, $context);
    }

    /**
     * @param non-empty-string         $format
     * @param array<int|string, mixed> $context
     *
     * @return array<int|string, mixed>
     */
    public function decode(string $data, string $format, array $context = []): array
    {
        /** @var array<int|string, mixed> $dataDecoded */
        $dataDecoded = $this->jsonEncoder->decode($data, $format, $context);

        return arrayReplaceValueRecursive($dataDecoded, '_', null);
    }

    /**
     * @param non-empty-string $format
     */
    public function supportsEncoding(string $format): bool
    {
        return $this->jsonEncoder->supportsEncoding($format);
    }

    /**
     * @param non-empty-string $format
     */
    public function supportsDecoding(string $format): bool
    {
        return $this->jsonEncoder->supportsDecoding($format);
    }
}
