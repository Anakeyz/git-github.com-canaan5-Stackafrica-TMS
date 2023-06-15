<?php

// Declare functions that would be used globally throughout the application.
use App\Models\Service;

/**
 * get the color value for a given status.
 * @param string $value
 * @return string
 */
function statusColor(string $value): string
{
    return match ($value) {
        'SUSPENDED', 'PENDING', 'CHARGE' => 'orange',
        'SUCCESS', 'SUCCESSFUL', 'ACTIVE', 'CREDIT' => 'green',
        'INACTIVE', 'FAILED', 'DISABLED', 'DEBIT' => 'red',
        default,     => 'blue',
    };
}

/**
 * Print date
 * Convert the date to a human-readable format as specified
 * @param \Illuminate\Support\Carbon $value
 * @param bool $time
 * @return string
 */
function pDate(\Illuminate\Support\Carbon $value, bool $time = false): string
{
    $format  = 'd/m/Y';
    $format = $time ? $format . ' H:i' : $format;

    return $value->format($format);
}


/**
 * Convert to human-readable format with country's currency
 *
 * @param float $value
 * @param string $symbol
 * @return string
 */
function moneyFormat(float $value, string $symbol = '₦'): string
{
    if ($value < 0) {
        $print_number = "($symbol" . str_replace('-', '', number_format ($value, 2, ".", ",")) . ")";
    } else {
        $print_number = "$symbol" .  number_format ((int) $value, 2, ".", ",") ;
    }

    return $print_number;
}

function allServices(): \Illuminate\Database\Eloquent\Collection
{
    return \Illuminate\Support\Facades\Cache::remember(
        'services',
        now()->addDay(),
        fn() => \App\Models\Service::all()
    );
}

function allLevels(): \Illuminate\Database\Eloquent\Collection
{
    return \Illuminate\Support\Facades\Cache::remember(
        'kyc-levels',
        now()->addDay(),
        fn() => \App\Models\KycLevel::orderBy('max_balance')->get()
    );
}

function defaultMenus()
{
    return Service::whereMenu(true)->get();
}
