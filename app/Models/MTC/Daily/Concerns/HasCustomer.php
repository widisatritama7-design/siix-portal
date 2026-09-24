<?php

namespace App\Models\MTC\Daily\Concerns;

trait HasCustomer
{
    public const CUSTOMERS = [
        'ASTRA VISTEON',
        'ICHIKOH',
        'KAWAI',
        'KOITO',
        'KOJIMA',
        'KUBOTA',
        'MITSUBA',
        'ROLAND',
        'SHARP',
        'TOKAI RIKA',
        'TOYODENSO',
        'SANKYO',
        'ASTRA JUOKU',
        'MINABEA',
        'HINO',
        'AMPAS',
        'GREENWAY ENERGY',
        'BOSCH AUTOMOTIVE',
    ];

    /**
     * Customer yang pakai Oxygen Density Special
     * (dan tidak pakai Oxygen Density SEK)
     */
    public const SPECIAL_OXYGEN_CUSTOMERS = [
        'MITSUBA',
        'TOKAI RIKA',
    ];

    public function usesSpecialOxygenDensity(): bool
    {
        return in_array($this->customer, self::SPECIAL_OXYGEN_CUSTOMERS, true);
    }

    /**
     * Override required fields oxygen density berdasarkan customer.
     * - MITSUBA / TOKAI RIKA → special required, sek NOT required
     * - Selain itu          → sek required, special NOT required
     */
    public function applyCustomerOxygenOverride(array $requiredFields): array
    {
        $requiredFields = array_values(array_diff($requiredFields, [
            'oxygent_density_sek',
            'oxygent_density_special',
        ]));

        if ($this->usesSpecialOxygenDensity()) {
            $requiredFields[] = 'oxygent_density_special';
        } else {
            $requiredFields[] = 'oxygent_density_sek';
        }

        return $requiredFields;
    }

    public static function customerOptions(): array
    {
        return self::CUSTOMERS;
    }
}