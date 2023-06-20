<?php

namespace App\Contract;

interface BaseService
{
    /**
     * Service provider name
     * @return string
     */
    public static function name(): string;
}
