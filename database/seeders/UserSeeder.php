<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Currency;

class UserSeeder extends Seeder
{
    public function run()
    { 
      $image =  ['1.png','2.png','3.png'];
      $users = [
            [
                'status' => 'active',
                'online_offline' => 'online',
                'account_number' => 2411111,
                'token' => Str::random(),
                'name' => "manager",
                'username' => "manager",
                'password' => Hash::make("admin"),
                'email' => "manager",
                'image' =>  "https://aquan.aquan.website/api/show/image/users/" . $image[array_rand($image)],
                'address' => "managaer",
                'phone' => "+2126000000",
                'phone_verified_at' => now(),
                'balance' => 30000,
                'phone_verification_code' => now(),
                'inactivate_end_at' => null,
                'upgraded_at' => now(),
                'refered_by' => null,
                'refcode' => "ADMIN",
                'plan_id' => 1, 
              
            ],
            [
                'status' => 'active',
                'token' => Str::random(),
                'online_offline' => 'online',
                'account_number' => 2421111,
                'name' => "Admin",
                'username' => "Admin",
                'password' => Hash::make("admin"),
                'email' => "Admin",
                'image' =>  "https://aquan.aquan.website/api/show/image/users/" . $image[array_rand($image)],
                'address' => "Admin",
                'phone' => "+2126000002",
                'phone_verified_at' => now(),
                'balance' => 35000,
                'phone_verification_code' => now(),
                'inactivate_end_at' => null,
                'upgraded_at' => now(),
                'comment' => "",
                'refered_by' => null,
                'refcode' => "MANAGER1",
                'plan_id' => 3,
            ],
            [
                'status' => 'active',
                'online_offline' => 'online',
                'account_number' =>2431111,
                'token' => Str::random(),
                'name' => "Employee",
                'username' => "Employee",
                'password' => Hash::make("admin"),
                'email' => "Employee",
                'image' =>  "https://aquan.aquan.website/api/show/image/users/" . $image[array_rand($image)],
                'address' => "Employee",
                'phone' => "+2126000003",
                'phone_verified_at' => now(),
                'balance' => 23000,
                'phone_verification_code' => now(),
                'inactivate_end_at' => null,
                'upgraded_at' => now(),
                'comment' => "",
                'refered_by' => null,
                'refcode' => "EMPLOYEE1",
                'plan_id' => 1,
            ],
            [
                'status' => 'active',
                'online_offline' => 'online',
                'account_number' =>2441111,
                'token' => Str::random(),
                'name' => "User",
                'username' => "User",
                'password' => Hash::make("admin"),
                'email' => "User",
                'image' =>  "https://aquan.aquan.website/api/show/image/users/" . $image[array_rand($image)],
                'address' => "User",
                'phone' => "+2126000006",
                'phone_verified_at' => now(),
                'balance' => 18000,
                'phone_verification_code' => now(),
                'inactivate_end_at' => null,
                'upgraded_at' => now(),
                'comment' => "",
                'refered_by' => null,
                'refcode' => "MANAGER2",
                'plan_id' => 3,
            ],
            [
                'status' => 'active',
                'online_offline' => 'online',
                 'account_number' =>2451111,
                'token' => Str::random(),
                'name' => "User2",
                'username' => "User2",
                'password' => Hash::make("admin"),
                'email' => "User2",
                'image' =>   "https://aquan.aquan.website/api/show/image/users/" . $image[array_rand($image)],
                'address' => "Address User2",
                'phone' => "+2126000007",
                'phone_verified_at' => now(),
                'balance' => 400,
                'phone_verification_code' => now(),
                'inactivate_end_at' => null,
                'upgraded_at' => now(),
                'comment' =>"",
                'refered_by' => null,
                'refcode' => "EMPLOYEE2",
                'plan_id' => 3,
            ],
        ];
        foreach ($users as $user) {
            $createdUser = User::updateOrCreate(
                ['refcode' => $user['refcode']],
                $user
            );
        }
    }
}
