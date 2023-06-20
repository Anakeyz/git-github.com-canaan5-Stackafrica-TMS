<?php

namespace App\Models;

use App\Exceptions\FailedApiResponse;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Builder;
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
 * <p>They include **bill payments**, **transfers**, **withdrawal**, **funding**, etc.
 */
class Service extends Model
{
    use HasFactory, LogsActivity, MustBeApproved;

    protected $guarded = ['id'];

    protected $casts = [
       'is_available' => 'boolean',
        'menu' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(fn ($service) => $service->slug = str($service->name)->slug(''));

        static::created(function ($service) {
            \Cache::forget('services');
            if ($service->wasChanged(['menu_name'])) \Cache::forget('default-menus');
        });

        static::updated(function ($service) {
            \Cache::forget('services');
            if ($service->wasChanged(['menu_name'])) \Cache::forget('default-menus');
        });
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

    public function provider(): BelongsTo
    {
        return $this->belongsTo(ServiceProvider::class, 'provider_id');
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

    /**
     * Get the class for the active provider of the service.
     *
     * @param string $service The slug for the service as stored in the db <i>services</i> table.
     * @param string $error_name The name of the error to show on failed response.
     * @return mixed
     * @throws \Throwable
     */
    public static function getActiveProviderFor(string $service, string $error_name): mixed
    {
        $provider = Service::whereSlug($service)->first()?->provider;

        throw_if(is_null($provider), new FailedApiResponse("$error_name is currently unavailable.", 404));

        return new $provider->class;
    }
}
