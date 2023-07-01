<?php

namespace App\Models;

use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TerminalProcessor extends Model
{
    use HasFactory, MustBeApproved;

    protected $guarded = ['id'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function createForTerminal(Terminal $terminal): void
    {
        Processor::each(function ($processor) use ($terminal) {
            $terminalProcessor = new TerminalProcessor([
                'user_id' => $terminal->user_id,
                'serial' => $terminal->serial,
                'processor_id' => $processor->id,
                'processor_name' => $terminal->serial,
                'tid' => '00000000',
                'mid' => '000000000000000',
                'category_code' => '0000'
            ]);

            $terminalProcessor->withoutApproval()->save();
        });
    }
}
