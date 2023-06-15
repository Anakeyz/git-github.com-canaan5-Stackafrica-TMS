<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Approval extends \Cjmellor\Approval\Models\Approval
{
    protected $appends = ['resource', 'action'];

    public function action(): Attribute
    {
        return Attribute::get(function () {
            if (empty($this->original_data->toArray())) return 'created';

            elseif (empty($this->new_data->toArray())) return 'deleted';

            else return 'updated';
        });
    }

    public function resource(): Attribute
    {
        return Attribute::get(fn() => str($this->approvalable_type)->remove("App\Models\\"));
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
