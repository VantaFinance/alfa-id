<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Response;

use Brick\PhoneNumber\PhoneNumber;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\AlfaId\Struct\Email;
use Vanta\Integration\AlfaId\Struct\Gender;
use Vanta\Integration\AlfaId\Struct\InnNumber;
use Vanta\Integration\AlfaId\Struct\SnilsNumber;

final readonly class UserInfo
{
    /**
     * @param non-empty-string      $rawValue
     * @param non-empty-string|null $iss
     * @param non-empty-string|null $name
     * @param non-empty-string|null $givenName
     * @param non-empty-string|null $familyName
     * @param non-empty-string|null $middleName
     * @param non-empty-string|null $identityDocumentName
     * @param non-empty-string|null $identityDocumentSeries
     * @param non-empty-string|null $identityDocumentNumber
     * @param non-empty-string|null $role
     * @param non-empty-string|null $actualAddress
     * @param non-empty-string|null $regAddress
     * @param non-empty-string|null $birthPlace
     * @param non-empty-string|null $identityDocumentAuthorityCode
     * @param non-empty-string|null $identityDocumentAuthorityName
     */
    public function __construct(
        public string $rawValue,
        public ?string $iss = null,
        public ?Uuid $sub = null,
        public ?Uuid $aud = null,
        public ?string $name = null,
        public ?string $givenName = null,
        public ?string $familyName = null,
        public ?string $middleName = null,
        public ?Email $email = null,
        public ?Gender $gender = null,
        #[Context([DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'])]
        public ?DateTimeImmutable $birthdate = null,
        public ?PhoneNumber $phoneNumber = null,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'U'])]
        public ?DateTimeImmutable $updatedAt = null,
        public ?InnNumber $inn = null,
        public ?string $identityDocumentName = null,
        public ?string $identityDocumentSeries = null,
        public ?string $identityDocumentNumber = null,
        public ?bool $eio = null,
        public ?string $role = null,
        public ?string $actualAddress = null,
        public ?string $regAddress = null,
        public ?string $birthPlace = null,
        public ?SnilsNumber $snils = null,
        public ?string $identityDocumentAuthorityCode = null,
        public ?string $identityDocumentAuthorityName = null,
        #[Context([DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public ?DateTimeImmutable $identityDocumentIssueDate = null,
    ) {
    }
}
