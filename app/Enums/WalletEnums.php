<?php

namespace App\Enums;

enum WalletEnums: string
{
    case WALLET1 = 'veterinarian_wallet';

    /**
     * Check if a given value is a valid enum case.
     */
    public static function isValid(string $type): bool
    {
        foreach (self::cases() as $case) {
            if ($case->value === $type) {
                return true;
            }
        }

        return false;
    }
}
