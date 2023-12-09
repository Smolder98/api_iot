<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::create([
            'name' => 'Device #1',
            'code' => '0011',
            'description' => 'Device #1 description',
            'status' => '1',
        ]);

        Device::create([
            'name' => 'Device #2',
            'code' => '0012',
            'description' => 'Device #2 description',
            'status' => '1',
        ]);

        Device::create([
            'name' => 'Device #3',
            'code' => '0013',
            'description' => 'Device #3 description',
            'status' => '1',
        ]);
    }
}
