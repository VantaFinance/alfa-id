<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Builder;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV7;
use Vanta\Integration\AlfaId\Struct\CodeChallengeMethod;
use Vanta\Integration\AlfaId\Struct\Prompt;
use Vanta\Integration\AlfaId\Struct\Scope;
use function Vanta\Integration\AlfaId\Response\array_enum_diff;

final readonly class AuthorizationUrlBuilder
{
    /**
     * @param non-empty-string $redirectUri
     * @param list<Scope> $scopes
     * @param non-empty-string|null $nonce
     * @param non-empty-string|null $codeChallenge
     * @param positive-int|null $maxAge
     * @param non-empty-string $responseType
     */
    public function __construct(
        private Uuid $clientId,
        private string $redirectUri,
        private array $scopes,
        private ?string $nonce,
        private ?string $codeChallenge,
        private ?CodeChallengeMethod $codeChallengeMethod,
        private ?Prompt $prompt,
        private ?int $maxAge,
        private ?Uuid $state = new UuidV7(),
        private string $responseType = 'code',
    ) {
    }

    public function withClientId(Uuid $clientId): self
    {
        return static(
            $clientId,
            $this->redirectUri,
            $this->scopes,
            $this->nonce,
            $this->codeChallenge,
            $this->codeChallengeMethod,
            $this->prompt,
            $this->maxAge,
            $this->state,
            $this->responseType,
        );
    }

    /**
     * @param non-empty-string $redirectUri
     */
    public function withRedirectUri(string $redirectUri): self
    {
        return static(
            $this->clientId,
            $redirectUri,
            $this->scopes,
            $this->nonce,
            $this->codeChallenge,
            $this->codeChallengeMethod,
            $this->prompt,
            $this->maxAge,
            $this->state,
            $this->responseType,
        );
    }

    /**
     * @param list<Scope> $scopes
     */
    public function withScopes(array $scopes): self
    {
        return static(
            $this->clientId,
            $this->redirectUri,
            $scopes,
            $this->nonce,
            $this->codeChallenge,
            $this->codeChallengeMethod,
            $this->prompt,
            $this->maxAge,
            $this->state,
            $this->responseType,
        );
    }

    public function withoutScope(Scope $scope): self
    {
        $scopes = array_enum_diff($this->scopes, [$scope]);

        return static(
            $this->clientId,
            $this->redirectUri,
            $scopes,
            $this->nonce,
            $this->codeChallenge,
            $this->codeChallengeMethod,
            $this->prompt,
            $this->maxAge,
            $this->state,
            $this->responseType,
        );
    }

    /**
     * @param non-empty-string|null $nonce
     */
    public function withNonce(?string $nonce): self
    {
        return static(
            $this->clientId,
            $this->redirectUri,
            $this->scopes,
            $nonce,
            $this->codeChallenge,
            $this->codeChallengeMethod,
            $this->prompt,
            $this->maxAge,
            $this->state,
            $this->responseType,
        );
    }

    /**
     * @param non-empty-string|null $codeChallenge
     */
    public function withCodeChallenge(?string $codeChallenge): self
    {
        return static(
            $this->clientId,
            $this->redirectUri,
            $this->scopes,
            $this->nonce,
            $codeChallenge,
            $this->codeChallengeMethod,
            $this->prompt,
            $this->maxAge,
            $this->state,
            $this->responseType,
        );
    }

    public function withCodeChallengeMethod(?CodeChallengeMethod $codeChallengeMethod): self
    {
        return static(
            $this->clientId,
            $this->redirectUri,
            $this->scopes,
            $this->nonce,
            $this->codeChallenge,
            $codeChallengeMethod,
            $this->prompt,
            $this->maxAge,
            $this->state,
            $this->responseType,
        );
    }

    public function withPrompt(?Prompt $prompt): self
    {
        return static(
            $this->clientId,
            $this->redirectUri,
            $this->scopes,
            $this->nonce,
            $this->codeChallenge,
            $this->codeChallengeMethod,
            $prompt,
            $this->maxAge,
            $this->state,
            $this->responseType,
        );
    }

    public function withMaxAge(?int $maxAge): self
    {
        return static(
            $this->clientId,
            $this->redirectUri,
            $this->scopes,
            $this->nonce,
            $this->codeChallenge,
            $this->codeChallengeMethod,
            $this->prompt,
            $maxAge,
            $this->state,
            $this->responseType,
        );
    }

    public function withState(?Uuid $state): self
    {
        return static(
            $this->clientId,
            $this->redirectUri,
            $this->scopes,
            $this->nonce,
            $this->codeChallenge,
            $this->codeChallengeMethod,
            $this->prompt,
            $this->maxAge,
            $state,
            $this->responseType,
        );
    }

    public function withResponseType(?string $responseType = 'code'): self
    {
        return static(
            $this->clientId,
            $this->redirectUri,
            $this->scopes,
            $this->nonce,
            $this->codeChallenge,
            $this->codeChallengeMethod,
            $this->prompt,
            $this->maxAge,
            $this->state,
            $responseType,
        );
    }

    /**
     * @return non-empty-string
     */
    public function build(): string
    {
        $query = [

        ];

        return sprintf('%s/auth/authorize?%s', $this->baseUri, http_build_query($query));
    }
}