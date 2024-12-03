<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(
            [
                RolesAndPermissionsSeeder::class,
                PlanSeeder::class,
                UserSeeder::class,
                PermissionsSeeder::class,
                CurrencySeeder::class,
                AccountsSeeder::class,
                TransferSeeder::class,
                SettingSeeder::class,
                ControllerSeeder::class,
                TasksSeeder::class,
                UserTasksSeeder::class,
                ChatSeeder::class,
                MessagesSeeder::class,
                RatesSeeder::class,
                PlansInvoicesSeeder::class,
                WithdrawsSeeder::class,
                DepositsSeeder::class,
                NotificationsSeeder::class,

            ],
        );
    }
}
