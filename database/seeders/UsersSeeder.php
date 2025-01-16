<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $image =  [
            '1.png',
            '2.png',
            '3.png',
        ];
        $users = [
            [
                'status' => true,
                'online_offline' => 'online',
                'first_name' => "manager",
                'last_name' => "manager",
                'password' => Hash::make("admin"),
                'email' => "manager",
                'image' =>  "https://m.aquan.website/public/storage/users/" . $image[array_rand($image)],
                'address' => "managaer",
                'phone' => "+2126000000",
            ],
            [
                'status' => true,
                'online_offline' => 'online',
                'first_name' => "Admin",
                'last_name' => "Admin",
                'password' => Hash::make("admin"),
                'email' => "Admin",
                'image' =>  "https://m.aquan.website/public/storage/users/" . $image[array_rand($image)],
                'address' => "Admin",
                'phone' => "+2126000002",
            ],
            [
                'status' => true,
                'online_offline' => 'online',
                'first_name' => "Employee",
                'last_name' => "Employee",
                'password' => Hash::make("admin"),
                'email' => "Employee",
                'image' =>  "https://m.aquan.website/public/storage/users/" . $image[array_rand($image)],
                'address' => "Employee",
                'phone' => "+2126000003",
            ],
            [
                'status' => true,
                'online_offline' => 'online',
                'first_name' => "User",
                'last_name' => "User",
                'password' => Hash::make("admin"),
                'email' => "User",
                'image' =>  "https://m.aquan.website/public/storage/users/" . $image[array_rand($image)],
                'address' => "User",
                'phone' => "+2126000006",
            ],
            [
                'status' => true,
                'online_offline' => 'online',
                'first_name' => "User2",
                'last_name' => "User2",
                'password' => Hash::make("admin"),
                'email' => "User2",
                'image' =>   "https://m.aquan.website/public/storage/users/" . $image[array_rand($image)],
                'address' => "Address User2",
                'phone' => "+2126000007",
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                [
                    'email' => $user['email'],
                ],
                $user
            );
        }
    }
}
