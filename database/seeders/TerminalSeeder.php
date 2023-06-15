<?php

namespace Database\Seeders;

use App\Helpers\RoleHelper;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agents = User::role('Agent')->get();

        $agents->each(fn(User $agent) => Terminal::factory()->create(['user_id' => $agent->id, 'group_id' => 1]));
    }
}
