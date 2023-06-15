<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Terminal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::each(fn($service) => $service->update([
            'menu_name' => str($service->name)->before('/')->value()
        ]));

        Terminal::each(
            fn(Terminal $terminal) => $terminal->menus()->sync(Service::all())
        );
    }
}
