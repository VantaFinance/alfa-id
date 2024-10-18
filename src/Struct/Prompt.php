<?php

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

enum Prompt: string
{
    /**
     * Недоступно отображение страницы пользовательского интерфейса аутентификации или согласия
     */
    case NONE = 'none';

    /**
     * Запрос у конечного пользователя повторной аутентификации
     */
    case LOGIN = 'login';

    /**
     * Запрос у конечного пользователя согласия, прежде чем возвращать информацию клиенту
     */
    case CONSENT = 'consent';
}