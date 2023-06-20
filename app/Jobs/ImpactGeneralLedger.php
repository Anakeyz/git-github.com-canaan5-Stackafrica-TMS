<?php

namespace App\Jobs;

use App\Enums\Action;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImpactGeneralLedger implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Action $action, public Transaction $transaction)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $gl = $this->transaction->service->generalLedger;

        $gl->recordTransaction(
            $this->action,
            $this->transaction->user_id,
            $this->transaction->amount,
            $this->transaction->info
        );
    }
}
