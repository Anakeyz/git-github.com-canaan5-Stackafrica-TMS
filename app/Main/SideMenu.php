<?php

namespace App\Main;

use App\Models\User;

class SideMenu
{
    /**
     * List of side menu items.
     *
     * @return array
     */
    public static function menu(): array
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'route_name' => 'dashboard',
                'title' => 'Dashboard'
            ],

            /*'income' => [
                'icon' => 'bar-chart',
                'title' => 'Income',
//                'route_name' => 'roles-permissions',
            ],*/

            'terminals' => [
                'icon' => 'smartphone',
                'title' => 'Terminals',
                'sub_menu' => [
                    'group' => [
                        'route_name' => 'terminal-groups.index',
                        'title' => 'Groups',
                        'permission' => 'read groups'
                    ],

                    'list' => [
                        'route_name' => 'terminals.index',
                        'title' => 'List',
                        'permission' => 'read terminals'
                    ],

                    'menus' => [
                        'route_name' => 'menus.index',
                        'title' => 'Menus',
                        'permission' => 'read menus'
                    ],
                ]
            ],

            'wallets' => [
                'icon' => 'credit-card',
                'title' => 'Wallets',
                'sub_menu' => [
                    'index' => [
                        'route_name' => 'wallets.index',
                        'title' => 'List'
                    ],

                    'transactions' => [
                        'route_name' => 'wallets.transactions',
                        'title' => 'Transactions'
                    ],
                ],
                'permission' => 'read wallets'
            ],

            'Transactions' => [
                'icon' => 'activity',
                'route_name' => 'transactions.index',
                'title' => 'Transactions',
                'permission' => 'read transactions'
            ],

            'general-ledger' => [
                'icon' => 'target',
                'title' => 'General Ledger',
                'route_name' => 'general-ledger.show',
                'permission' => 'read general ledger'
            ],

            'ledger' => [
                'icon' => 'book-open',
                'title' => 'Ledger',
                'route_name' => 'ledger.index',
                'permission' => 'read ledger'
            ],

            'users' => [
                'icon' => 'users',
                'title' => 'User Management',
                'sub_menu' => [
                    'staff' => [
                        'route_name' => 'admins.index',
                        'title' => User::GROUPS[0],
                        'permission' => 'read admin'
                    ],

                    'agents' => [
                        'route_name' => 'agents.index',
                        'title' => 'Customers',
                        'permission' => 'read customers'
                    ],
                ]
            ],

            'kyc-details' => [
                'icon' => 'folder',
                'title' => 'KYC Management',
                'sub_menu' => [
                    'kyc-level' => [
                        'route_name' => 'kyc-levels.index',
                        'title' => 'KYC Level'
                    ],

                    'kyc-docs' => [
                        'route_name' => 'kyc-docs.index',
                        'title' => 'KYC Documents'
                    ],
                ],
                'permission' => 'read kyc-level'
            ],



            'access-control' => [
                'icon' => 'sliders',
                'title' => 'Access Control',
                'route_active' => 'roles.index, roles.create',
                'sub_menu' => [
                    'index' => [
                        'route_name' => 'roles.index',
                        'title' => 'Roles'
                    ],

                    'transactions' => [
                        'route_name' => 'permissions.index',
                        'title' => 'Permissions'
                    ],
                ],
                'permission' => 'read roles'
            ],

//            'roles-n-permissions' => [
//                'icon' => 'sliders',
//                'route_name' => 'access-control.index',
//                'route_active' => 'access-control.index, access-control.create-role',
//                'title' => 'Roles & Permissions'
//            ],

            'settings' => [
                'icon' => 'settings',
                'title' => 'Settings',
                'sub_menu' => [
                    'services' => [
                        'route_name' => 'services.index',
                        'title' => 'Services and Providers'
                    ],
                    'routing' => [
                        'icon' => 'send',
                        'route_name' => 'routing.index',
                        'title' => 'Routing',
                    ],

//                    'settlement' => [
////                        'route_name' => 'manage-users.agents',
//                        'title' => 'Settlements'
//                    ],
                ],
                'permission' => 'read settings'
            ],

            'approvals' => [
                'icon' => 'user-check',
                'route_name' => 'approvals.index',
                'title' => 'Approvals',
                'permission' => 'approve actions'
            ],

            'app-management' => [
                'icon' => 'cpu',
//                'route_name' => 'roles-permissions',
                'title' => 'App Management',
                'permission' => 'read settings'
            ],

//            'dispute-management' => [
//                'icon' => 'alert-triangle',
////                'route_name' => 'roles-permissions',
//                'title' => 'Dispute Management'
//            ],

            'activities' => [
                'icon' => 'framer',
                'route_name' => 'activities',
                'title' => 'Audit Trail',
                'permission' => 'read admin'
            ],
        ];
    }
}
