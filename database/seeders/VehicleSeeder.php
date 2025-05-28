<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;
        DB::table('vehicles')->insert([
            [
                'user_id' => $userId,
                'license_plate' => 'B 1234 ABC',
                'type' => 'Motor',
                'brand' => 'Honda',
                'color' => 'Merah',
                'is_stolen' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'license_plate' => 'D 5678 XYZ',
                'type' => 'Mobil',
                'brand' => 'Toyota',
                'color' => 'Hitam',
                'is_stolen' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'license_plate' => 'F 9876 PQR',
                'type' => 'Mobil',
                'brand' => 'Suzuki',
                'color' => 'Putih',
                'is_stolen' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'user_id' => $userId,
                'license_plate' => 'F 9876 PQR',
                'type' => 'JIA',
                'brand' => 'JIA MOTOR',
                'color' => 'NEON',
                'is_stolen' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
