<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Fee extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'config'    => 'array'
    ];


    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function group()
    {
        return $this->belongsTo(TerminalGroup::class);
    }


    /**
     * Create Default fees
     * or create fees for the specified group if a @groupId attribute is passed
     *
     * @param $groupId
     * @return void
     */
    public static function createDefault( $groupId = null )
    {
        Service::where('id', '!=', 1)->each(function ( $service ) use ( $groupId ) {

            $config = collect([]);
            if ( $service->name == 'BANK TRANSFER' ) {
                $config = collect([
                    '0-5000'        => 10.00,
                    '5001-50000'    => 21.51,
                    '50001-1000000' => 30.00
                ]);
            }

            Fee::updateOrCreate([
                'group_id'       => $groupId ?? TerminalGroup::orderBy('id', 'asc')->first()?->id,
                'service_id'    => $service->id,
                'title'         => $service->name,
            ], [
                'amount'        => 10.00,
                'config'        => $config
            ]);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Fee')
            ->logOnly(['title']);
    }
}
