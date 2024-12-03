<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rate;
use App\Models\Currency;

class RatesSeeder extends Seeder
{
    public function run()
    {
        $rates = [
            //  1  /  plan  /  1  //
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 1,
                "to" => 2,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 1,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 1,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 1,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),
            ],
            //  1  /  plan  /  2  //
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 1,
                "to" => 2,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 1,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 1,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 1,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),
            ],
            //  1  /  plan  /  3  //
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 1,
                "to" => 2,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 1,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 1,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 1,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),

            ],
            //  2   //  plan   //  1  //
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 2,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),

            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 2,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),

            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 2,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 2,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),

            ],
            //  2   //  plan   //  2  //
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 2,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),

            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 2,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),

            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 2,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 2,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),

            ],
            //  2   //  plan   //  3  //
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 2,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 2,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),

            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 2,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 2,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),
            ],
            //  3   //  plan   //  1  //
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 3,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 3,
                "to" => 2,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 3,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 3,
                "to" => 5,
                "price" => 1.1,
            ],
            //  3   //  plan   //  2  //
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 3,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 3,
                "to" => 2,
                "price" => 1.1,
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 3,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 3,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),
            ],
            //  3   //  plan   //  3  //
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 3,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 3,
                "to" => 2,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 3,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 3,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),
            ],
            //  4   //  plan   //  1  //
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 4,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 4,
                "to" => 2,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 4,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 4,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),
            ],
            //  4   //  plan   //  2  //
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 4,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 4,
                "to" => 2,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 4,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 4,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),
            ],
            //  4   //  plan   //  3  //
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 4,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 4,
                "to" => 2,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 4,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 4,
                "to" => 5,
                "price" =>  $this->generateRandomPrice(),
            ],

            //  5   //  plan   //  1  //
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 5,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 5,
                "to" => 2,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 5,
                "to" => 3,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 1,
                "from" => 5,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            //  5   //  plan   //  2  //
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 5,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 5,
                "to" => 2,
                "price" => $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 5,
                "to" => 3,
                "price" => $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 2,
                "from" => 5,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
            //  5   //  plan   //  3  //
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 5,
                "to" => 1,
                "price" =>  $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 5,
                "to" => 2,
                "price" => $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 5,
                "to" => 3,
                "price" => $this->generateRandomPrice(),
            ],
            [
                "status" => false,
                "plan_id" => 3,
                "from" => 5,
                "to" => 4,
                "price" =>  $this->generateRandomPrice(),
            ],
        ];

        foreach ($rates as $rate) {
            Rate::updateOrCreate(
                $rate
            );
        }
    }
    private function generateRandomPrice()
    {
        return mt_rand(1000, 3000) + mt_rand(0, 99) / 100;
    }
}
