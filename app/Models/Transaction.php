<?php

namespace App\Models;

use App\Enums\Status;
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

    protected $guarded = ['id'];

    protected $with = ['service'];

    protected $casts = [
        'meta' => 'object',
        'wallet_debited' => 'boolean',
        'status' => Status::class
    ];

// Relationships
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'type_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function terminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class);
    }

    public function scopeSuccessful($query)
    {
        $query->where('status', Status::SUCCESSFUL->value);
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

    public function scopeCashout(Builder $builder)
    {
        $builder->whereRelation('service', 'slug', 'cashoutwithdrawal');
    }

    public function scopeTransfer(Builder $builder)
    {
        $builder->whereRelation('service', 'slug', 'banktransfer')
            ->orWhereRelation('service', 'slug', 'wallettransfer');
    }

    public function scopeBillPayment(Builder $builder)
    {
        $builder->whereRelation('service', 'slug', 'airtime')
            ->orWhereRelation('service', 'slug', 'internetdata')
            ->orWhereRelation('service', 'slug', 'cabletv')
            ->orWhereRelation('service', 'slug', 'electricity');
    }

    public function scopeSumAndCount(Builder $builder)
    {
        return $builder->selectRaw('count(*) as count, sum(amount) as amount_sum')->first();
    }

    /**
     * Create a pending transaction for the terminal instance.
     */
    public static function createPendingFor(
        Terminal $terminal,
        Service $service,
        float $amount,
        float $totalAmount,
        string $reference,
        string $narration,
        string $provider): static
    {
        return $terminal->owner->transactions()->create([
            'terminal_id'   => $terminal->id,
            'amount'        => $amount,
            'total_amount'  => $totalAmount,
            'charge'        => $totalAmount - $amount,
            'reference'     => $reference,
            'info'          => $narration,
            'type_id'       => $service->id,
            'status'        => Status::PENDING,
            'provider'      => $provider,
            'version'       => request('VERSION'),
            'channel'       => request('CHANNEL'),
            'device'       => request('DEVICE'),
        ]);
    }
}
