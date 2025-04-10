<?php

namespace Larafor\Bloodgroup\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Larafor\Bloodgroup\Models\BloodGroup;
use Illuminate\Database\Seeder;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $bloodgroupsData = config('bloodgroup.bloodgroups');
        foreach ($bloodgroupsData as $bloodgroup) {
            BloodGroup::firstOrCreate(['name' => $bloodgroup['name']], $bloodgroup);
        }
    }
}
