<?php

namespace Database\Seeders;

use App\Helpers\AppConfig;
use App\Helpers\WalletHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
// Default credentials
        $teq = \App\Models\User::factory()->create([
            'first_name' => 'Teqtms',
            'other_names' => 'Admin',
            'email' => 'admin@teqtms.com',
            'phone' => '09012345678',
            'status' => 'ACTIVE',
        ]);

        $teq->first()->assignRole('Super Admin');

        // Fake admin
//        $admin = User::factory()->times(9)->create();
//
//        $admin_roles = Role::query()->where('type', User::GROUPS[0])->pluck('name')->toArray();
//
////        assign role to admin
//        $admin->each(fn(User $user) => $user->assignRole($admin_roles[rand(0,1)]));
//
//        $super_agent = User::factory()->times(3)->create(['level_id' => 1]);
//        $super_agent->each(fn(User $user) => $user->assignRole('Super Agent'));
//
//        $agent = User::factory()->times(3)->create(['level_id' => 1]);
//        $agent->each( fn(User $user) => $user->assignRole('Agent'));

        // create agents
        $agent = \App\Models\User::factory()->create([
            'first_name' => 'Canaan',
            'other_names' => 'Etai',
            'email' => 'canaanetai@gmail.com',
            'phone' => '08163240721',
            'password' => 'password',
            'status' => 'ACTIVE',
        ]);
        $agent->assignRole('Agent');

        $agent = \App\Models\User::factory()->create([
            'first_name' => 'Lyte',
            'other_names' => 'Onyema',
            'email' => 'lyte@gmail.com',
            'phone' => '09012347584',
            'password' => 'password',
            'status' => 'ACTIVE',
        ]);
        $agent->assignRole('Agent');

        $agent = \App\Models\User::factory()->create([
            'first_name' => 'Sanusi',
            'other_names' => 'Segun',
            'email' => 'sanusi@gmail.com',
            'phone' => '08082722783',
            'password' => 'password',
            'status' => 'ACTIVE',
        ]);
        $agent->assignRole('Agent');
    }
}
