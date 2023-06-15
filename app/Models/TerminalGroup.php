<?php

namespace App\Models;

use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalGroup extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function fees()
    {
        return $this->hasMany(Fee::class, 'group_id');
    }

    public function terminals()
    {
        return $this->hasMany(Terminal::class, 'group_id');
    }
}
