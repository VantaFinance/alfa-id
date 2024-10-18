<?php

/**
 * Vanta Alfa-id
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Response;

use BackedEnum;

/**
 * @template T of \BackedEnum
 *
 * @param array<T> $one
 * @param array<T> $two
 *
 * @return array<T>
 */
function array_enum_diff(array $one, array $two): array
{
    return array_udiff(
        $one,
        $two,
        static fn (BackedEnum $a, BackedEnum $b): int => strcmp((string) $a->value, (string) $b->value)
    );
}

function underscoreToCamelCase(string $input): string
{
    $result = str_replace('_', ' ', $input);
    $result = ucwords($result);
    $result = str_replace(' ', '', $result);
    $result[0] = strtolower($result[0]);

    return $result;
}
