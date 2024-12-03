<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Currency;
use App\Models\Plan;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $methods =  [
            [
                "name" => "Binance",
                "code" => "USDT",
            ],
            [
                "name" => "بنكك",
                "code" => "SDG",
            ],
            [
                "name" => "Payeer",
                "code" => "USD",
            ],
            [
                "name" => "Perfect Money",
                "code" => "USD",
            ],
            [
                "name" => "TRC 20",
                "code" => "USD",
            ],
        ];
        foreach ($methods as $method) {
            Currency::create(
                [
                    'status' => true,
                    'name' => $method['name'],
                    'name_code' => $method['code'],
                    'comment' => "This is comment"
                ],
            );
        }
    }
}
