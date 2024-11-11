<?php

namespace Database\Seeders;

use App\Models\DeliveryType;
use App\Models\PackageStatus;
use Illuminate\Database\Seeder;

class PackageStatusAndDeliveryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packageStatuses = ['created', 'pending', 'received', 'shipped', 'delivered', 'returned', 'archived'];
        $deliveryTypes = ['standard', 'express'];
        foreach ($packageStatuses as $status) {
            PackageStatus::updateOrCreate(['name' => $status]);
        }
        foreach ($deliveryTypes as $type) {
            DeliveryType::updateOrCreate(['name' => $type]);
        }
    }
}
