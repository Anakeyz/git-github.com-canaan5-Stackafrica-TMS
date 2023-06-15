<?php

namespace App\Observers;

use App\Models\Fee;
use App\Models\TerminalGroup;

class TerminalGroupObserver
{
    public function created(TerminalGroup $terminalGroup)
    {
        Fee::createDefault($terminalGroup->id);
    }
}
