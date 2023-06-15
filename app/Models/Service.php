<?php

namespace App\Models;

use App\Helpers\General;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * These hold the services for which every transaction occurring on the system is carried out for.
 * They include bill payments, transfers, etc.
 */
class Service extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
       'is_available' => 'boolean',
        'menu' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->slug = str($model->name)->slug(''));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

// Relationships

    public function providers(): HasMany
    {
        return $this->hasMany(ServiceProvider::class);
    }

    public function selectedProvider(): BelongsTo
    {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function generalLedger(): HasOne
    {
        return $this->hasOne(GeneralLedger::class);
    }

    public function terminals(): BelongsToMany
    {
        return $this->belongsToMany(Terminal::class)->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Service')
            ->logOnly(['name', 'description', 'provider']);
    }

    public function scopeWithSearch(Builder $query, $search): Builder
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }
}
