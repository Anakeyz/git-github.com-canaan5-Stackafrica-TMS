<?php

namespace App\Helpers;

use App\Models\CashoutTransaction;
use App\Models\Transaction;
use App\Models\WalletTransaction;
use Illuminate\Support\Str;

class General
{
    public static function generateSlug(string $value): string
    {
        return Str::slug($value, '');
    }


    /**
     * @param string $type
     * @param int $length
     * @return string
     */
    public static function generateReference( string $type = 'billpayment', int $length = 16 ): string
    {
        start:
        $reference = strtoupper(Str::random($length));

        switch ($type) {
            case 'transfer':
            case 'billpayment':
                if ( Transaction::whereReference($reference)->exists() ) goto start;
                break;

            case 'cashout':
                if ( CashoutTransaction::whereReference($reference)->exists() ) goto start;
                break;
        }

        return $reference;
    }
}
