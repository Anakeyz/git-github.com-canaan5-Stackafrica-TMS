<?php

namespace App\Models;

use App\Traits\HasFiltering;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class WalletTransaction extends Model
{
    use HasFactory, HasFiltering, LogsActivity;

    const REASON = ['TRANSACTION', 'CHARGE'];

    const TYPE = ['CREDIT', 'DEBIT'];

    protected $guarded = ['id'];

    protected $with = ['wallet'];

    // Relationships

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'product_id');
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'SUCCESSFUL');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Wallet-transaction')
            ->logOnly(['status']);
    }

    public function scopeWithSearch(Builder $query, $search): Builder
    {
        return $query->where('reference', 'like', '%' . $search . '%')
            ->orWhereHas('wallet', fn($query) => $query->withSearch($search));

    }
}
