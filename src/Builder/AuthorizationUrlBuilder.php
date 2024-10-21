<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Builder;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV7;

use function Vanta\Integration\AlfaId\Response\array_enum_diff;

use Vanta\Integration\AlfaId\Struct\CodeChallengeMethod;
use Vanta\Integration\AlfaId\Struct\Prompt;
use Vanta\Integration\AlfaId\Struct\Scope;

final readonly class AuthorizationUrlBuilder
{
    /**
     * @param non-empty-string      $baseUri
     * @param non-empty-string      $redirectUri
     * @param list<Scope>           $scopes
     * @param non-empty-string|null $codeChallenge
     * @param positive-int|null     $maxAge
     * @param non-empty-string      $responseType
     */
    public function __construct(
        private string $baseUri,
        private Uuid $clientId,
        private string $redirectUri,
        private array $scopes,
        private ?string $nonce = null,
        private ?string $codeChallenge = null,
        private ?CodeChallengeMethod $codeChallengeMethod = null,
        private ?Prompt $prompt = null,
        private ?int $maxAge = null,
        private ?Uuid $state = new UuidV7(),
        private string $responseType = 'code',
    ) {
    }

    /**
     * @param non-empty-string $baseUri
     */
    public function withBaseUri(string $baseUri): self
    {
        return new static(
            baseUri: $baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $this->scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    public function withClientId(Uuid $clientId): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $clientId,
            redirectUri: $this->redirectUri,
            scopes: $this->scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    /**
     * @param non-empty-string $redirectUri
     */
    public function withRedirectUri(string $redirectUri): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $redirectUri,
            scopes: $this->scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    /**
     * @param list<Scope> $scopes
     */
    public function withScopes(array $scopes): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    public function withoutScope(Scope $scope): self
    {
        $scopes = array_enum_diff($this->scopes, [$scope]);

        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    /**
     * @param non-empty-string|null $nonce
     */
    public function withNonce(?string $nonce): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $this->scopes,
            nonce: $nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    /**
     * @param non-empty-string|null $codeChallenge
     */
    public function withCodeChallenge(?string $codeChallenge): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $this->scopes,
            nonce: $this->nonce,
            codeChallenge: $codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    public function withCodeChallengeMethod(?CodeChallengeMethod $codeChallengeMethod): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $this->scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    public function withPrompt(?Prompt $prompt): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $this->scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    /**
     * @param positive-int|null $maxAge
     */
    public function withMaxAge(?int $maxAge): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $this->scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $maxAge,
            state: $this->state,
            responseType: $this->responseType,
        );
    }

    public function withState(?Uuid $state = new UuidV7()): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $this->scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $state,
            responseType: $this->responseType,
        );
    }

    /**
     * @param non-empty-string $responseType
     */
    public function withResponseType(string $responseType = 'code'): self
    {
        return new static(
            baseUri: $this->baseUri,
            clientId: $this->clientId,
            redirectUri: $this->redirectUri,
            scopes: $this->scopes,
            nonce: $this->nonce,
            codeChallenge: $this->codeChallenge,
            codeChallengeMethod: $this->codeChallengeMethod,
            prompt: $this->prompt,
            maxAge: $this->maxAge,
            state: $this->state,
            responseType: $responseType,
        );
    }

    /**
     * @return non-empty-string
     */
    public function build(): string
    {
        $query = [
            'client_id'    => $this->clientId->toString(),
            'redirect_uri' => $this->redirectUri,
            'scope'        => implode(
                ' ',
                array_map(fn (Scope $scope) => $scope->value, $this->scopes),
            ),
            'nonce'                 => $this->nonce,
            'code_challenge'        => $this->codeChallenge,
            'code_challenge_method' => $this->codeChallengeMethod?->value,
            'prompt'                => $this->prompt?->value,
            'max_age'               => $this->maxAge,
            'state'                 => $this->state?->toString(),
            'response_type'         => $this->responseType,
        ];

        // убираем null
        $query = array_filter($query, static fn ($value) => null !== $value);

        return sprintf('%s/oidc/authorize?%s', $this->baseUri, http_build_query($query));
    }
}
