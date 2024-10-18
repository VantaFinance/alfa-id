<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId;

use GuzzleHttp\Client;
use LogicException;
use Psr\Http\Client\ClientInterface as PsrHttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\ConfigurationClient;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\HttpClient;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\ClientErrorMiddleware;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\InternalServerMiddleware;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\Middleware;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\PipelineMiddleware;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\Middleware\UrlMiddleware;
use Vanta\Integration\AlfaId\Infrastructure\Serializer\Encoder\JwtTokenEncoder;
use Vanta\Integration\AlfaId\Transport\RestApiClient;
use Vanta\Integration\AlfaId\Transport\RestOidcClient;

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
            new MetadataAwareNameConverter($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter()),
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
            $objectNormalizer,
        ];

        $middlewares = [
            new UrlMiddleware(),
            new ClientErrorMiddleware(),
            new InternalServerMiddleware(),
        ];

        return new self(
            $client,
            new SymfonySerializer($normalizers, [new JsonEncoder(), new JwtTokenEncoder()]),
            $configuration,
            $middlewares
        );
    }

    /**
     * @param non-empty-string $localCertPath
     * @param non-empty-string $localPk
     * @param non-empty-string $passphrase
     *
     * @throws LogicException
     */
    public static function createWithSymfonyHttpClient(ConfigurationClient $configuration, string $localCertPath, string $localPk, string $passphrase): self
    {
        if (!class_exists(Psr18Client::class)) {
            throw new LogicException(sprintf(
                'Class %s is not exists. Try running "composer require symfony/http-client".',
                Psr18Client::class
            ));
        }

        $httpClient = new Psr18Client();
        $httpClient = $httpClient->withOptions([
            'local_cert' => $localCertPath,
            'local_pk'   => $localPk,
            'passphrase' => $passphrase,
        ]);

        return self::create($configuration, $httpClient);
    }

    /**
     * @param non-empty-string $localCertPath
     * @param non-empty-string $localPk
     * @param non-empty-string $passphrase
     *
     * @throws LogicException
     */
    public static function createWithSymfonyGuzzleClient(ConfigurationClient $configuration, string $localCertPath, string $localPk, string $passphrase): self
    {
        if (!class_exists(Client::class)) {
            throw new LogicException(sprintf(
                'Class %s is not exists. Try running "composer require guzzlehttp/guzzle".',
                Client::class
            ));
        }

        $httpClient = new Client([
            'cert'    => $localCertPath,
            'ssl_key' => [$localPk, $passphrase],
        ]);

        return self::create($configuration, $httpClient);
    }

    public function withClient(PsrHttpClient $client): self
    {
        return new self(
            client: $client,
            serializer: $this->serializer,
            configuration: $this->configuration,
            middlewares: $this->middlewares
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

    public function createApiClient(): ApiClient
    {
        return new RestApiClient(
            $this->serializer,
            new HttpClient(
                $this->configuration->withRedirectUri($this->configuration->redirectUri),
                new PipelineMiddleware($this->middlewares, $this->client),
            ),
            $this->configuration,
        );
    }

    public function createOidcClient(): OidcClient
    {
        return new RestOidcClient(
            $this->serializer,
            new HttpClient(
                $this->configuration->withRedirectUri($this->configuration->redirectUri),
                new PipelineMiddleware($this->middlewares, $this->client),
            ),
            $this->configuration,
        );
    }
}
