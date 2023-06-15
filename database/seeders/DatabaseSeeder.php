<?php

namespace Database\Seeders;

use App\Models\KycLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // create default configs

//        $this->seedWithMysql();

        $this->call([
            ConfigSeeder::class,
            RoleSeeder::class,
            RoutingSeeder::class,
            KycLevelSeeder::class,
            UserSeeder::class,
            ServiceSeeder::class,
            MenuNameSeeder::class,
            TerminalGroupSeeder::class,
            FeeSeeder::class,
            GeneralLedgerSeeder::class,
            GLTSeeder::class,
            TerminalSeeder::class,
            TransactionSeeder::class,
        ]);
    }

    public function seedWithMysql()
    {
        $seed = File::get(database_path('seeders/teqtms-1.sql'));
        DB::connection()->getPdo()->exec($seed);
    }
}
