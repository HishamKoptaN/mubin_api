<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $places = ['مدرسة', 'مسجد'];
        $base_url = 'https://api.aquan.website/public/orders';
        for ($clientIndex = 1; $clientIndex <= 5; $clientIndex++) {
            for ($i = 1; $i <= 5; $i++) {
                Order::create(
                    [
                        'latitude' => 37.7749,
                        'longitude' => -122.4194,
                        'image_one' => "{$base_url}/client_{$clientIndex}/order_{$i}/1.jpg",
                        'image_two' => "{$base_url}/client_{$clientIndex}/order_{$i}/2.jpg",
                        'video' => "{$base_url}/client_{$clientIndex}/order_{$i}/1.mp4",
                        'place' => $places[array_rand($places)],
                        'branch_id' => rand(1, 8),
                        'client_id' => $clientIndex,
                    ],
                );
            }
        }
    }
}
