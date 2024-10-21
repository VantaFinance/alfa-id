<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

enum CodeChallengeMethod: string
{
    /**
     * Код верификатор
     */
    case PLAIN = 'plain';

    /**
     * S256 BASE64URL-ENCODE(SHA256(ASCII(Код верификатор)))
     */
    case S256 = 'S256';
}
