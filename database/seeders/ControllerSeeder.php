<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Controller;

class ControllerSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Controller::create([
            'branch_branch' => 'Buy Sell Status',
            'status' => 1,
             'message' => "Message",
        ]);
    }
}
