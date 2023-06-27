<?php

namespace App\Models;

use App\Traits\BelongsToSuperAgent;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class KycDoc extends Model
{
    use HasFactory, LogsActivity, MustBeApproved, BelongsToSuperAgent;

    protected $guarded = ['id'];

    const TYPE = ['TEXT', 'FILE'];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


//    Attribute

    public function path(): Attribute
    {
        return Attribute::get(fn($value) => asset('storage/'. $value));
    }

    public function ext(): Attribute
    {
        return Attribute::get( fn() => str($this->path)->afterLast('.'));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('KycDocs')
            ->logOnly(['name', 'path']);
    }
}
