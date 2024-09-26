<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $plans =  [
            [
                'name' => "الأول",
                'amount' => 0.0,
                'user_amount_per_referal' => 0,
                'refered_amount' => 0,
                'amount_after_count' => 0,
                'count' => 0,
                'transfer_commission'=> 0,
                'discount' => 0,
                'discount_type' => null,
                'daily_transfer_count' => 10,
                'monthly_transfer_count' => 10,
            ],
            [
                'name' => "الثاني",
                'amount' => 20,
                'user_amount_per_referal' => 5,
                'refered_amount' => 10,
                'amount_after_count' => 5,
                'count' => 10, 
                'transfer_commission'=> 0.5,
                'discount' => 10,
                'discount_type' => "fixed",
                'daily_transfer_count' => 10,
                'monthly_transfer_count' => 100,
            ],
            [
                'name' => "الثالث",
                'amount' => 50,
                'user_amount_per_referal' => 10,
                'refered_amount' => 10,
                'amount_after_count' => 10,
                'count' => 5,
                'transfer_commission'=> 1,
                'discount' => 20,
                'discount_type' => "procentage",
                'daily_transfer_count' => 15,
                'monthly_transfer_count' => 200,
            ],
        ];

        // foreach ($plans as $k => $plan) {

        //     $selling_prices = [];
        //     $buying_prices = [];

        //     foreach (Currency::get() as $currency) {
        //         $selling_prices[$currency->id]['name'] = $currency->name;
        //         $selling_prices[$currency->id]['price'] = 1.02;

        //         $buying_prices[$currency->id]['name'] = $currency->name;
        //         $buying_prices[$currency->id]['price'] = 1.02;
        //     }

        //     $plans[$k]['selling_prices'] = $selling_prices;
        //     $plans[$k]['buying_prices'] = $buying_prices;
        // }

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
