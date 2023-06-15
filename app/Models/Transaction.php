<?php

namespace App\Models;

use App\Traits\HasFiltering;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use HasFactory, HasFiltering, LogsActivity;

    const ALL_STATUS = ['SUCCESSFUL', 'PENDING', 'FAILED'];

    protected $with = ['service'];
// Relationships

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'type_id');
    }

    public function agent(): BelongsTo
    {
        return  $this->belongsTo(User::class, 'user_id');
    }

    public function terminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class);
    }

    public function scopeSuccessful($query)
    {
        $query->where('status', 'SUCCESSFUL');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Transaction')
            ->logOnly(['account_name', 'status', 'bank_name', 'total_amount']);
    }

    public function scopeWithSearch(Builder $query, string $search): void
    {
        $query->where('reference', 'like', '%' . $search . '%')
            ->orWhereHas('agent', fn($query) => $query->withSearch($search))
            ->orWhereHas('service', fn($query) => $query->withSearch($search));
    }

    public function scopeSumAmountAndCountByService(Builder $query): void
    {
        $query->join('services', 'transactions.type_id', 'services.id')
            ->groupBy('slug')->orderBy('slug')
            ->selectRaw('slug, services.name, sum(amount) as amount, count(*) as count');
    }
}
