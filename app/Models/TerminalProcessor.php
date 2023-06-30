<?php

namespace App\Models;

use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalProcessor extends Model
{
    use HasFactory, MustBeApproved;

    protected $guarded = ['id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
