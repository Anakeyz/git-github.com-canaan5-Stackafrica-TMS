<?php

namespace App\Models;

use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Processor extends Model
{
    use HasFactory, MustBeApproved;

    protected $guarded = ['id'];

    public function terminals(): HasMany
    {
        return $this->hasMany(TerminalProcessor::class);
    }
}
