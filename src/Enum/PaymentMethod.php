<?php

namespace App\Enum;

enum PaymentMethod: string
{
    case CREDIT_CARD = 'credit_card';
    case AIRTEL_MONEY = 'airtel_money';
    case MTN_MOMO = 'mtn_momo';

    /**
     * @return array<string,string>
     */
    public static function getAsArray(): array
    {
        return array_reduce(
            self::cases(),
            static fn (array $choices, PaymentMethod $method) => $choices + [$method->name => $method->value],
            [],
        );
    }
}
