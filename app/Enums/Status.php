<?php

namespace App\Enums;

enum Status: string
{
    case SUCCESSFUL = 'SUCCESSFUL';
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';
    case APPROVED = 'APPROVED';
    case DECLINED = 'DECLINED';
    case CONFIRMED = 'CONFIRMED';
    case REPAID = 'REPAID';

    public static function forTransaction(): array
    {
        return array_column([self::PENDING, self::SUCCESSFUL, self::FAILED], 'value');
    }

    public static function forLoans(): array
    {
        return  array_column([self::PENDING, self::APPROVED, self::DECLINED, self::CONFIRMED, self::REPAID], 'value');
    }
}
