<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Branch;
use Illuminate\Support\Facades\Storage;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $places = [
            'مدرسة',
            'مسجد',
        ];

        for ($index = 1; $index <= 8; $index++) {
            for ($i = 1; $i <= 20; $i++) {
                Order::create(
                    [
                        'latitude' => 37.7749,
                        'longitude' => -122.4194,
                        'image_one' => "https://m.aquan.website/public/storage/orders/{$index}/{$i}/image_one.jpg",
                        'image_two' => "https://m.aquan.website/public/storage/orders/{$index}/{$i}/image_two.jpg",
                        'video' => "https://m.aquan.website/public/storage/orders/{$index}/{$i}/video.mp4",
                        'place' => $places[array_rand(
                            $places,
                        )],
                        'branch_id' => $index,
                        'client_id' => $index,
                    ],
                );
            }
        }
    }
}
