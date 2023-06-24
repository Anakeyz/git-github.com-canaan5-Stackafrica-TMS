<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Seed permissions
        collect($this->permissionsSeeder())->each(fn($value) => Permission::create(['name' => $value]));

        $staff_roles = [Role::ADMIN, Role::SUPERADMIN];
        $agent_roles = [Role::SUPERAGENT, Role::AGENT];

//        create roles for admin and super admin
        collect($staff_roles)->each(function ($value) {
            $role = Role::create([
                'name' => $value,
                'type' => User::GROUPS[0]
            ]);

            $role->givePermissionTo(Permission::pluck('name')->toArray());
        });

        $role = Role::create([
            'name' => 'APPROVER',
            'type' => User::GROUPS[0]
        ]);

        $role->givePermissionTo('approve actions');

        collect($agent_roles)->each(fn($value) => Role::create([
            'name' => $value,
            'type' => User::GROUPS[1]
        ]));
    }

    private function permissionsSeeder(): array
    {
        return [
            'access admin',
            'read users',
            'create user',
            'modify user',
            'disable user',
            'read kyc-level',
            'modify kyc-level',
            'read roles',
            'create role',
            'edit roles',
            'delete roles',
            'edit permission',
            'read wallets',
            'modify wallet',
            'read terminals',
            'create terminal',
            'edit terminal',
            'delete terminal',
            'read fees',
            'modify fees',
            'read general ledger',
            'modify general ledger',
            'read ledger',
            'read dispute',
            'create dispute',
            'modify dispute',
            'read settings',
            'modify settings',
            'read accounts',
            'approve actions',
        ];

    }
}
