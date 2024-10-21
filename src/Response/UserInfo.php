<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Response;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;

final readonly class UserInfo
{
    /**
     * @param non-empty-string      $rawValue
     * @param non-empty-string|null $iss
     * @param non-empty-string|null $name
     * @param non-empty-string|null $givenName
     * @param non-empty-string|null $familyName
     * @param non-empty-string|null $middleName
     * @param non-empty-string|null $email
     * @param non-empty-string|null $gender
     * @param non-empty-string|null $phoneNumber
     * @param non-empty-string|null $inn
     * @param non-empty-string|null $identityDocumentName
     * @param non-empty-string|null $identityDocumentSeries
     * @param non-empty-string|null $identityDocumentNumber
     * @param non-empty-string|null $role
     * @param non-empty-string|null $actualAddress
     * @param non-empty-string|null $regAddress
     * @param non-empty-string|null $birthPlace
     * @param non-empty-string|null $snils
     * @param non-empty-string|null $identityDocumentAuthorityCode
     * @param non-empty-string|null $identityDocumentAuthorityName
     * @param non-empty-string|null $identityDocumentIssueDate
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
        public ?string $email = null,
        public ?string $gender = null,
        #[Context([DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'])]
        public ?DateTimeImmutable $birthdate = null,
        public ?string $phoneNumber = null,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'U'])]
        public ?DateTimeImmutable $updatedAt = null,
        public ?string $inn = null,
        public ?string $identityDocumentName = null,
        public ?string $identityDocumentSeries = null,
        public ?string $identityDocumentNumber = null,
        public ?bool $eio = null,
        public ?string $role = null,
        public ?string $actualAddress = null,
        public ?string $regAddress = null,
        public ?string $birthPlace = null,
        public ?string $snils = null,
        public ?string $identityDocumentAuthorityCode = null,
        public ?string $identityDocumentAuthorityName = null,
        #[Context([DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public ?string $identityDocumentIssueDate = null,
    ) {
    }
}
