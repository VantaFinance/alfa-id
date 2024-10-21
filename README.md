# Alfa id клиент

Клиент для общения со [API alfa id](https://developers.alfabank.ru/products/alfa-api/documentation/articles/alfa-id/articles/intro/intro).

## Установка

Минимальная версия PHP: 8.3

1. Выполнить `composer require vanta/alfa-id-client`
2. Обязательно установить PSR-совместимый клиент

## Использование

Создание инстанса клиента:

```php
use GuzzleHttp\Client;
use Symfony\Component\HttpClient\Psr18Client;
use Vanta\Integration\AlfaId\Infrastructure\HttpClient\ConfigurationClient;
use Vanta\Integration\AlfaId\RestClientBuilder;

// создаем http клиент и настраиваем на работу с сертификатами от alfa id
$httpClient = new Psr18Client(); // symfony клиент
$httpClient = $httpClient->withOptions([
    'local_cert' => '../test_cert_alfa_id/sandbox_cert_2025.cer',
    'local_pk' => '../test_cert_alfa_id/sandbox_key_2025.key',
    'passphrase' => 'somePassphrase',
]);

$httpClient = new Client([ // guzzle клиент
    'cert'    => '../test_cert_alfa_id/sandbox_cert_2025.cer',
    'ssl_key' => ['../test_cert_alfa_id/sandbox_key_2025.key', 'somePassphrase'],
]);

$restClientBuilder = RestClientBuilder::create(new ConfigurationClient(Uuid::fromString('ваш clientId'), 'https://sandbox.alfabank.ru'), $httpClient);

$authClientSdk = $restClientBuilder->createAuthClient();
$userClientSdk  = $restClientBuilder->createUserClient();
```

Генерация URL для авторизации пользователя:

```php

$authorizationUrl = $restClientBuilder->createAuthUrlBuilder('https://id-sandbox.alfabank.ru', 'https://vanta.ru')
    ->build()
;

```

Получение токена:

```php
$token = $userClientSdk->getToken('get параметр code, из url-а, на который вернулся пользователь после авторизации в alfa-е', 'https://vanta.ru');
```

Обновление токена:

```php
$token = $userClientSdk->refreshToken($token->refreshToken);
```

Получение данных о пользователе:

```php
$clientResponse = $userClientSdk->getUserinfo($token->tokenType, $token->accessToken);
```

