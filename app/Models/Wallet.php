<?php

namespace App\Models;

use App\Traits\HasWalletMethods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Wallet extends Model
{
    use HasFactory, LogsActivity, HasWalletMethods;

    protected $guarded = ['id'];

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($wallet) {
            $wallet->uwid = Uuid::uuid2(Uuid::DCE_DOMAIN_PERSON);
            $wallet->account_number = self::generateAccountNumber();
        });
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where('uwid', $value)->firstOrFail();
    }


//      Relationships

    /**
     * Wallet belongs to user
     * @return BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')
            ->select('first_name', 'other_names', 'id', 'phone', 'email', 'status', 'level_id');
    }

    /**
     * Wallet has Many Transactions
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

//    Attribute

    public function isActive(): Attribute
    {
        return Attribute::get(
            fn($value) => $this->status == 'ACTIVE'
        );
    }

    /**
     * Change the terminal status to the opposite value
     */
    public function changeStatus(): void
    {
        $this->status = $this->is_active ? 'SUSPENDED' : 'ACTIVE';
        $this->save();
    }

    /**
     * @return string
     */
    private static function generateAccountNumber(): string
    {
        start:
        $number = '30' . rand(10000000, 99999999);

        if ( self::whereAccountNumber($number)->exists() ) goto start;

        return $number;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Wallet')
            ->logOnly(['account_number', 'status']);
    }
    public function scopeWithSearch(Builder $query, $search): Builder
    {
        return $query->where('account_number', 'like', '%' . $search . '%')
            ->orWhereHas('agent', fn($query) => $query->withSearch($search));
    }
}
