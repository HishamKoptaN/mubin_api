<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;

class MessagesSeeder extends Seeder
{
    public function run()
    {
        $randomNumbers1 = [3, 4];
        $randomNumbers2 = [3, 5];
        
        for ($k = 0; $k < 8; $k++) {
            Message::create([
                'message' => Str::random(20),
                'user_id' => $randomNumbers1[array_rand($randomNumbers1)],
                'chat_id' => 1,
            ]);
        }
        
        for ($k = 0; $k < 8; $k++) {
            Message::create([
                'message' => Str::random(20),
                'user_id' => $randomNumbers2[array_rand($randomNumbers2)],
                'chat_id' => 2,   
         ]); 
        }  
            
    }
}
