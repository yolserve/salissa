<?php

namespace App\Enum;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';

    /**
     * @return array<string,string>
     */
    public static function getAsArray(): array
    {
        return array_reduce(
            self::cases(),
            static fn (array $choices, PaymentStatus $status) => $choices + [$status->name => $status->value],
            [],
        );
    }
}
