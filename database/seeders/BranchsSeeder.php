<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchsSeeder extends Seeder
{
    public function run()
    {
        // الفروع الأصلية
        Branch::create([
            'name' => 'Main Branch',
        ]);
        Branch::create([
            'name' => 'Secondary Branch',
        ]);
        Branch::create([
            'name' => 'Tertiary Branch',
        ]);
        // إضافة الفروع الجديدة
        Branch::create([
            'name' => 'kinia',
        ]);
        Branch::create([
            'name' => 'tanzania',
        ]);
        Branch::create([
            'name' => 'benin',
        ]);
        Branch::create([
            'name' => 'cameroun',
        ]);
        Branch::create([
            'name' => 'ghana',
        ]);
        Branch::create([
            'name' => 'guinee',
        ]);
        Branch::create([
            'name' => 'malawi',
        ]);
        Branch::create([
            'name' => 'uganda',
        ]);
    }
}
