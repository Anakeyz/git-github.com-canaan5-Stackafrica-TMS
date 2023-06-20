<?php

namespace Database\Seeders;

use App\Helpers\General;
use App\Http\Controllers\Approvals;
use App\Models\Approval;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = ['CASHOUT/WITHDRAWAL', 'CABLE TV', 'AIRTIME', 'INTERNET DATA', 'ELECTRICITY', 'BANK TRANSFER', 'WALLET TRANSFER', 'FUNDING/INBOUND'];

        collect($services)->each(function ($service) {
            $s = (new Service([
                'name'  => $service,
                'menu_name' => str($service)->before('/')->value()
            ]));

            $s->withoutApproval()->save();

            if ($service == 'WALLET TRANSFER') {
                ServiceProvider::create([
                    'service_id'    => $s->id,
                    'name'          => 'INTERNAL',
                ]);
            }

            if ($service != 'FUNDING/INBOUND' || $service != 'CASHOUT/WITHDRAWAL') {
                ServiceProvider::create([
                    'service_id' => $s->id,
                    'name' => 'Spout',
                    'class' => '\App\Repository\Spout'
                ]);
            }
        });
    }
}
