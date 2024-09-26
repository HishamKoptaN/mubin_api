<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        foreach (User::all() as $user) {
            foreach (Currency::all() as $c) {
                Wallet::create([
                    'amount' => rand(1, 200),
                    // 'image',
                    'user_id' => $user->id,
                    'currency_id' => $c->id
                ]);
            }
        }
    }
}
