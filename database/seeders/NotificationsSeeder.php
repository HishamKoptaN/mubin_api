<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Notification;

class NotificationsSeeder extends Seeder
{
    public function run(): void
    {   
        $types = ['public', 'public'];
        $userIds = range(1, 5); 
        $notifications = [];

        for ($i = 0; $i < 10; $i++) {
            $randomUserIds = array_rand(array_flip($userIds), rand(1, count($userIds)));
            if (!is_array($randomUserIds)) {
                $randomUserIds = [$randomUserIds];
            }
            $notifications[] = [
                'type' => $types[array_rand($types)],
                'notifiable_id' => json_encode($randomUserIds),
                'message' => 'This is notification number ' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('notifications')->insert($notifications);
    }
}
