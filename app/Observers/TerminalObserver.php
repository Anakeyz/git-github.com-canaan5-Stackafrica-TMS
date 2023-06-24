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
        $terminal->status = 'ACTIVE';
        $terminal->tmk = General::generateReference(length: 38);
        $terminal->tpk = General::generateReference(length: 38);
        $terminal->tsk = General::generateReference(length: 38);
        $terminal->date_time = now()->format('d/m/y H:i');
        $terminal->category_code = General::generateReference(length: 38);
        $terminal->name_location = General::generateReference(length: 38);
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
