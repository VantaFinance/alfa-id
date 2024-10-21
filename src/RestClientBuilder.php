<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId;

use Psr\Http\Client\ClientInterface as PsrHttpClient;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder as JsonEncoderSymfony;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV7;
use Vanta\Integration\AlfaId\Builder\AuthorizationUrlBuilder;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\ConfigurationClient;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\HttpClient;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\AuthMiddleware;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\ClientErrorMiddleware;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\InternalServerMiddleware;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\Middleware;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\PipelineMiddleware;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\UrlMiddleware;
use Vanta\Integration\AlfaId\Infrastructure\Serializer\Encoder\JsonEncoder;
use Vanta\Integration\AlfaId\Infrastructure\Serializer\Encoder\JwtTokenEncoder;
use Vanta\Integration\AlfaId\Infrastructure\Serializer\Normalizer\EmailNormalizer;
use Vanta\Integration\AlfaId\Infrastructure\Serializer\Normalizer\InnNumberNormalizer;
use Vanta\Integration\AlfaId\Infrastructure\Serializer\Normalizer\PhoneNumberNormalizer;
use Vanta\Integration\AlfaId\Infrastructure\Serializer\Normalizer\SnilsNumberNormalizer;
use Vanta\Integration\AlfaId\Struct\CodeChallengeMethod;
use Vanta\Integration\AlfaId\Struct\Prompt;
use Vanta\Integration\AlfaId\Struct\Scope;
use Vanta\Integration\AlfaId\Transport\RestAuthClient;
use Vanta\Integration\AlfaId\Transport\RestUserClient;

final readonly class RestClientBuilder
{
    /**
     * @param non-empty-list<Middleware> $middlewares
     */
    private function __construct(
        private PsrHttpClient $client,
        public Serializer $serializer,
        private ConfigurationClient $configuration,
        private array $middlewares,
    ) {
    }

    public static function create(ConfigurationClient $configuration, PsrHttpClient $client): self
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $objectNormalizer     = new ObjectNormalizer(
            $classMetadataFactory,
            new MetadataAwareNameConverter($classMetadataFactory),
            null,
            new PropertyInfoExtractor(
                [],
                [new PhpStanExtractor()],
                [],
                [],
                []
            ),
            new ClassDiscriminatorFromClassMetadata($classMetadataFactory),
        );

        $normalizers = [
            new BackedEnumNormalizer(),
            new UidNormalizer(),
            new DateTimeNormalizer(),
            new EmailNormalizer(),
            new InnNumberNormalizer(),
            new PhoneNumberNormalizer(),
            new SnilsNumberNormalizer(),
            $objectNormalizer,
        ];

        $middlewares = [
            new UrlMiddleware(),
            new ClientErrorMiddleware(),
            new InternalServerMiddleware(),
        ];

        return new self(
            $client,
            new SymfonySerializer($normalizers, [new JsonEncoder(new JsonEncoderSymfony()), new JwtTokenEncoder()]),
            $configuration,
            $middlewares
        );
    }

    public function withSerializer(Serializer $serializer): self
    {
        return new self(
            client: $this->client,
            serializer: $serializer,
            configuration: $this->configuration,
            middlewares: $this->middlewares
        );
    }

    public function withConfiguration(ConfigurationClient $configuration): self
    {
        return new self(
            client: $this->client,
            serializer: $this->serializer,
            configuration: $configuration,
            middlewares: $this->middlewares
        );
    }

    public function addMiddleware(Middleware $middleware): self
    {
        return new self(
            client: $this->client,
            serializer: $this->serializer,
            configuration: $this->configuration,
            middlewares: array_merge($this->middlewares, [$middleware])
        );
    }

    /**
     * @param non-empty-list<Middleware> $middlewares
     */
    public function withMiddlewares(array $middlewares): self
    {
        return new self(
            client: $this->client,
            serializer: $this->serializer,
            configuration: $this->configuration,
            middlewares: $middlewares
        );
    }

    public function createUserClient(): UserClient
    {
        return new RestUserClient(
            $this->serializer,
            new HttpClient(
                $this->configuration,
                new PipelineMiddleware([new AuthMiddleware($this->createAuthClient()), ...$this->middlewares], $this->client),
            ),
            $this->configuration,
        );
    }

    public function createAuthClient(): AuthClient
    {
        return new RestAuthClient(
            $this->serializer,
            new HttpClient(
                $this->configuration,
                new PipelineMiddleware($this->middlewares, $this->client),
            ),
            $this->configuration,
        );
    }

    /**
     * @param non-empty-string      $baseUri
     * @param non-empty-string      $redirectUri
     * @param list<Scope>           $scopes
     * @param non-empty-string|null $codeChallenge
     * @param positive-int|null     $maxAge
     * @param non-empty-string      $responseType
     */
    public function createAuthorizationUrlBuilder(
        string $baseUri,
        Uuid $clientId,
        string $redirectUri,
        array $scopes,
        ?string $nonce = null,
        ?string $codeChallenge = null,
        ?CodeChallengeMethod $codeChallengeMethod = null,
        ?Prompt $prompt = null,
        ?int $maxAge = null,
        ?Uuid $state = new UuidV7(),
        string $responseType = 'code',
    ): AuthorizationUrlBuilder {
        return new AuthorizationUrlBuilder(
            $baseUri,
            $clientId,
            $redirectUri,
            $scopes,
            $nonce,
            $codeChallenge,
            $codeChallengeMethod,
            $prompt,
            $maxAge,
            $state,
            $responseType,
        );
    }
}
