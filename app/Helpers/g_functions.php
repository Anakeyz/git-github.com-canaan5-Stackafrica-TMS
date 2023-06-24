<?php

// Declare functions that would be used globally throughout the application.
use App\Enums\Action;
use App\Enums\Status;
use App\Models\Service;

/**
 * get the color value for a given status.
 * @param string|Status|Action $value
 * @return string
 */
function statusColor(string|Status|Action $value): string
{
    return match ($value) {
        Status::PENDING, 'SUSPENDED', 'CHARGE' => 'orange',
        Status::SUCCESSFUL, Action::CREDIT, 'SUCCESS', 'ACTIVE' => 'green',
        Status::FAILED, Action::DEBIT, 'INACTIVE', 'DISABLED' => 'red',
        default  => 'blue',
    };
}


/**
 * Convert to human-readable format with country's currency
 *
 * @param float|null $value
 * @param string $symbol
 * @return string
 */
function moneyFormat(float|null $value, string $symbol = '₦'): string
{
    $value ??= 0;

    return $value < 0 ? "($symbol" . abs(number_format($value, 2, )) . ")" :
        "$symbol" .  number_format ($value, 2, );
}
