<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'Withdraws',
            'Deposits',
            'PlansInvoices',
            'UsersTasks',
            'Users',
            'Tasks',
            'Transfers',
            'Notifications',
            'Support',
            'DailyRates',
            'Controller',
            'Accounts',
            'Plans',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $roles = [
            'manager',
            'admin',
            'plansAdmin',
            'employee',
            'user',
        ];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
