<?php

namespace App\Models;

use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GeneralLedger extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function glts(): HasMany
    {
        return $this->hasMany(GLT::class, 'gl_id');
    }

    public function recordTransaction(string $type, int $userId, float $amount, string $info)
    {
        $prev_bal = $this->balance;

        if (!in_array($type, Wallet::IMPACT_TYPE)) abort(400);

        $type == 'DEBIT' ? $this->debit($amount) : $this->credit($amount);

        $this->glts()->create([
            'from_user_id'  => $userId,
            'amount'        => $amount,
            'type'          => $type,
            'prev_balance'  => $prev_bal,
            'new_balance'   => $this->balance,
            'info'          => $info
        ]);
    }

    private function credit(float $amount)
    {
        $this->update(['balance' => $this->balance + $amount]);
    }

    private function debit(float $amount)
    {
        $this->update(['balance' => $this->balance - $amount]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('GL')
            ->logOnly(['balance']);
    }

    /**
     * Get the summarized balance for each service and the total balance.
     *
     * @return object<string, numeric>
     */
    public static function getBalances(): object
    {
        $gls = self::join('services', 'general_ledgers.service_id', 'services.id')->pluck('balance', 'slug');

        return (object) [
            'total' => collect($gls)->sum(),
            'cashout' => $gls['cashoutwithdrawal'],
            'airtime_data' => $gls['airtime'] + $gls['internetdata'],
            'bill_payments' => $gls['cabletv'] + $gls['electricity'],
            'transfer' => $gls['banktransfer']
        ];
    }
}
