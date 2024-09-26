<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\User;

class PermissionsSeeder extends Seeder
{ 
    public function run()
    {  
        $permissions = [
            1,  
            2,  
            3,  
            4,  
            5,  
            6,  
            7, 
            8, 
            9,
            10,
            11,
            12,
            13,
        ];
        $userId = 1;
        $data = [];
        foreach ($permissions as $permissionId) {
            $data[] = [
                'permission_id' => $permissionId,
                'user_id' => $userId,
            ];
        }
        DB::table('user_has_permissions')->insert($data);
    }
}