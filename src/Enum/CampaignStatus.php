<?php

namespace App\Enum;

enum CampaignStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    /**
     * @return array<string,string>
     */
    public static function getAsArray(): array
    {
        return array_reduce(
            self::cases(),
            static fn (array $choices, CampaignStatus $status) => $choices + [$status->name => $status->value],
            [],
        );
    }
}
