<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => Status::class
    ];

    public function agent():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
