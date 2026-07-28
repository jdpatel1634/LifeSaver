<?php

namespace App\Factories;

class BloodCompatibilityFactory
{
    public static function compatibleDonorGroups(string $recipientBloodGroup): array
    {
        $recipientBloodGroup = self::normalizeBloodGroup($recipientBloodGroup);

        return match ($recipientBloodGroup) {
            'A+' => ['A+', 'A-', 'O+', 'O-'],
            'A-' => ['A-', 'O-'],
            'B+' => ['B+', 'B-', 'O+', 'O-'],
            'B-' => ['B-', 'O-'],
            'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            'AB-' => ['A-', 'B-', 'AB-', 'O-'],
            'O+' => ['O+', 'O-'],
            'O-' => ['O-'],
            default => [],
        };
    }

    public static function canDonateTo(string $donorBloodGroup, string $recipientBloodGroup): bool
    {
        $donorBloodGroup = self::normalizeBloodGroup($donorBloodGroup);

        return in_array(
            $donorBloodGroup,
            self::compatibleDonorGroups($recipientBloodGroup),
            true
        );
    }

    public static function normalizeBloodGroup(string $bloodGroup): string
    {
        $bloodGroup = strtoupper(trim($bloodGroup));

        // Normalize different dash/minus symbols.
        $bloodGroup = str_replace(['−', '–', '—'], '-', $bloodGroup);

        return match ($bloodGroup) {
            'A POSITIVE', 'A_POSITIVE', 'APOSITIVE', 'A PLUS', 'A+' => 'A+',
            'A NEGATIVE', 'A_NEGATIVE', 'ANEGATIVE', 'A MINUS', 'A-' => 'A-',

            'B POSITIVE', 'B_POSITIVE', 'BPOSITIVE', 'B PLUS', 'B+' => 'B+',
            'B NEGATIVE', 'B_NEGATIVE', 'BNEGATIVE', 'B MINUS', 'B-' => 'B-',

            'AB POSITIVE', 'AB_POSITIVE', 'ABPOSITIVE', 'AB PLUS', 'AB+' => 'AB+',
            'AB NEGATIVE', 'AB_NEGATIVE', 'ABNEGATIVE', 'AB MINUS', 'AB-' => 'AB-',

            'O POSITIVE', 'O_POSITIVE', 'OPOSITIVE', 'O PLUS', 'O+' => 'O+',
            'O NEGATIVE', 'O_NEGATIVE', 'ONEGATIVE', 'O MINUS', 'O-' => 'O-',

            default => $bloodGroup,
        };
    }
}
