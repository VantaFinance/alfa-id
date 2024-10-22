<?php
/**
 * Alfa id
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\AlfaId\Struct;

use Webmozart\Assert\Assert;

final readonly class SnilsNumber
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value,
    ) {
        Assert::regex($value, '/^\d{11}$/', 'Неверный формат данных, ожидаемый формат: 11 цифр');
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
