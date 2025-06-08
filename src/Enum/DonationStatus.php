<?php

namespace App\Enum;

enum DonationStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';

    /**
     * @return array<string,string>
     */
    public static function getAsArray(): array
    {
        return array_reduce(
            self::cases(),
            static fn (array $choices, DonationStatus $status) => $choices + [$status->name => $status->value],
            [],
        );
    }
}
