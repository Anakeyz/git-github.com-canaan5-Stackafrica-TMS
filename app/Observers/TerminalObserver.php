<?php

namespace App\Observers;

use App\Helpers\General;
use App\Models\Service;
use App\Models\Terminal;

class TerminalObserver
{
    /**
     * Handle the Terminal "created" event.
     */
    public function creating(Terminal $terminal): void
    {
        $nl = substr($terminal->owner->name, 0, 21) . '-'. substr(env('APP_NAME'), 0, 11);

        $terminal->status = 'ACTIVE';
        $terminal->tmk = strtoupper(General::generateReference(length: 38));
        $terminal->tpk = strtoupper(General::generateReference(length: 38));
        $terminal->tsk = strtoupper(General::generateReference(length: 38));
        $terminal->date_time = now()->format('d/m/y H:i');
        $terminal->category_code = General::generateReference(length: 4);
        $terminal->name_location = str_pad($nl, 35, ' ', STR_PAD_RIGHT) . 'LA NG';
    }

    /**
     * Handle the Terminal "updated" event.
     */
    public function created(Terminal $terminal): void
    {
        $terminal->menus()->attach(Service::all());
    }

    /**
     * Handle the Terminal "updated" event.
     */
    public function updated(Terminal $terminal): void
    {
        //
    }

    /**
     * Handle the Terminal "deleted" event.
     */
    public function deleted(Terminal $terminal): void
    {
        //
    }

    /**
     * Handle the Terminal "restored" event.
     */
    public function restored(Terminal $terminal): void
    {
        //
    }

    /**
     * Handle the Terminal "force deleted" event.
     */
    public function forceDeleted(Terminal $terminal): void
    {
        //
    }
}
