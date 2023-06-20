<?php

namespace App\Enums;

enum Status: string
{
    case SUCCESSFUL = 'SUCCESSFUL';
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
