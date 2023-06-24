<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

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
            'first_name' => 'Stack',
            'other_names' => 'Admin',
            'email' => 'info@getstack.africa',
            'phone' => '08081234567',
            'status' => 'ACTIVE',
        ]);

        $teq->first()->assignRole(Role::SUPERADMIN);

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
//        $agent = User::factory()->times(13)->create(['level_id' => 1]);
//
//        $agent->each( fn(User $user) => $user->assignRole('Agent'));
    }
}
