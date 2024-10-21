<?php
/**
 * Alfa id
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

enum Gender: string
{
    case MALE   = 'мужчина';
    case FEMALE = 'женщина';
}
