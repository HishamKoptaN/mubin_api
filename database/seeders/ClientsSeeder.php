<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 8; $i++) {
            DB::table('clients')->insert(
                [
                    'name' => "عميل{$i}",
                ],
            );
        }
    }
}
