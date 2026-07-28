<?php

namespace App\Factories;

class BloodCompatibilityFactory
{
    public static function compatibleDonorGroups(string $recipientBloodGroup): array
    {
        return match (strtoupper($recipientBloodGroup)) {
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
        return in_array(
            strtoupper($donorBloodGroup),
            self::compatibleDonorGroups($recipientBloodGroup),
            true
        );
    }
}