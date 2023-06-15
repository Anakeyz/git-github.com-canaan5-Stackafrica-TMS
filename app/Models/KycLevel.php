<?php

namespace App\Models;

use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class KycLevel extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function name(): Attribute
    {
        return Attribute::set(fn($value) => strtoupper($value));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('KycLevel')
            ->logOnly(['name', 'daily_limit']);
    }
}
