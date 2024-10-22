<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

enum TokenGrantType: string
{
    case AUTHORIZATION_CODE = 'authorization_code';

    case REFRESH_TOKEN = 'refresh_token';
}
