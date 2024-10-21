<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Transport;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface as HttpClient;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\ConfigurationClient;
use Vanta\Integration\AlfaId\Infrastructure\Serializer\Encoder\JwtTokenEncoder;
use Vanta\Integration\AlfaId\Response\UserInfo;
use Vanta\Integration\AlfaId\Struct\Token;
use Vanta\Integration\AlfaId\Struct\TokenGrantType;
use Vanta\Integration\AlfaId\Struct\TokenType;
use Vanta\Integration\AlfaId\UserClient;
use Yiisoft\Http\Method;

final readonly class RestUserClient implements UserClient
{
    public function __construct(
        private Serializer $serializer,
        private HttpClient $client,
        private ConfigurationClient $configurationClient,
    ) {
    }

    public function getToken(string $code, string $redirectUri, ?string $codeVerifier = null): Token
    {
        $requestData = [
            'grant_type'   => TokenGrantType::AUTHORIZATION_CODE->value,
            'code'         => $code,
            'client_id'    => $this->configurationClient->clientId->toString(),
            'redirect_uri' => $redirectUri,
        ];

        if (null !== $codeVerifier) {
            $requestData['code_verifier'] = $codeVerifier;
        }

        $request = new Request(
            Method::POST,
            '/api/token',
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            http_build_query($requestData),
        );

        $response = $this->client->sendRequest($request)->getBody()->__toString();

        return $this->serializer->deserialize($response, Token::class, 'json');
    }

    public function refreshToken(string $refreshToken): Token
    {
        $requestData = [
            'grant_type'    => TokenGrantType::REFRESH_TOKEN->value,
            'refresh_token' => $refreshToken,
            'client_id'     => $this->configurationClient->clientId->toString(),
        ];

        $request = new Request(
            Method::POST,
            '/api/token',
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            http_build_query($requestData),
        );

        $response = $this->client->sendRequest($request)->getBody()->__toString();

        return $this->serializer->deserialize($response, Token::class, 'json');
    }

    public function getUserInfo(TokenType $type, string $token): UserInfo
    {
        $request = new Request(
            Method::GET,
            '/api/userinfo',
            [
                'Authorization' => $type->value . ' ' . $token,
                'Accept'        => 'application/jwt',
            ],
        );

        $response = $this->client->sendRequest($request)->getBody()->__toString();

        return $this->serializer->deserialize($response, UserInfo::class, JwtTokenEncoder::FORMAT);

    }
}
