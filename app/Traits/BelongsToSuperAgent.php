<?php

namespace App\Traits;

use App\Models\Scopes\SuperAgentScope;

trait BelongsToSuperAgent
{
    public static function bootBelongsToSuperAgent(): void
    {
        static::addGlobalScope(new SuperAgentScope);
    }
}
