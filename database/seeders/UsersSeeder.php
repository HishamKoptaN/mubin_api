<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            // kenya
            [
                'id' => 1,
                'status' => true,
                'firebase_uid' => 'uPOcERkvb1fz4QXzn5YvVOTqhPl1',
                'online_offline' => true,
                'role' => 'kenya',
            ],
            // tanzania
            [
                'id' => 2,
                'status' => true,
                'firebase_uid' => 'kMQzV1gzLLeZerptZXsEfW1KW0e2',
                'online_offline' => true,
                'role' => 'tanzania',

            ],
            // malawi
            [
                'id' => 3,
                'online_offline' => true,
                'status' => true,
                'firebase_uid' => '4o3LIzBjniQZtOcgRFuajErAmiQ2',
                'role' => 'malawi',
            ],
            // cameroun
            [
                'id' => 4,
                'status' => true,
                'firebase_uid' => 'TC8mWPWTKsfS5DlawAD0t8ahPbC3',
                'online_offline' => true,
                'role' => 'cameroun',
            ],

            // benin
            [
                'id' => 5,
                'status' => true,
                'firebase_uid' => '8pnr7PxXXNUJlgTmOqdlw9zaDNf2',
                'online_offline' => true,
                'role' => 'benin',
            ],
            // ghana
            [
                'id' => 6,
                'status' => true,
                'firebase_uid' => 'bjlGcMMZc7SAuRj0E18O6bY37My1',
                'online_offline' => true,
                'role' => 'ghana',
            ],
            // guinee
            [
                'id' => 7,
                'status' => true,
                'firebase_uid' => 'IuiMY3jC3RVH4g7TiGc6FcRiFZC3',
                'online_offline' => true,
                'role' => 'guinee',
            ],
            // uganda
            [
                'id' => 8,
                'status' => true,
                'firebase_uid' => 'UwlQ1tnR5ZWH8E9SWX0rpuTyxSr1',
                'online_offline' => true,
                'role' => 'uganda',
            ],
            // owner
            [
                'id' => 9,
                'status' => true,
                'firebase_uid' => 'YW8dYpn5HMYg0pwp3PI0KYwtt3r1',
                'online_offline' => true,
                'role' => 'owner',
            ],
            // manager
            [
                'id' => 10,
                'status' => true,
                'firebase_uid' => 'iU3hcT2aZfMyN5EGQAFNXRDXTf62',
                'online_offline' => true,
                'role' => 'manager',
            ],
            // admin
            [
                'id' => 11,
                'status' => true,
                'firebase_uid' => 'B1fLapJEyDgvQX9ehtraesSd2rJ3',
                'online_offline' => true,
                'role' => 'admin'
            ],

        ];
        foreach ($users as $userData) {
            $user = User::create([
                'id' => $userData['id'],
                'status' => true,
                'firebase_uid' => $userData['firebase_uid'],
                'online_offline' => true,
            ],
        );
            $user->syncRoles([$userData['role']]);

        }
    }
}
