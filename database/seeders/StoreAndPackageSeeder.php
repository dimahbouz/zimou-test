<?php

namespace Database\Seeders;

use App\Models\Commune;
use App\Models\DeliveryType;
use App\Models\Package;
use App\Models\PackageStatus;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreAndPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        define("Database\Seeders\TOTAL_STORES", 5000);
        define("Database\Seeders\STORES_LOT", 100);
        define("Database\Seeders\PACKAGES_PER_STORE", 100);

        $communeIds = Commune::pluck('id')->toArray();
        $deliveryTypeIds = DeliveryType::pluck('id')->toArray();
        $packageStatusIds = PackageStatus::pluck('id')->toArray();
        $now = now();
        for ($i = 0; $i < TOTAL_STORES; $i += STORES_LOT) {
            $storeData = [];
            for ($j = 0; $j < STORES_LOT; $j++) {
                $storeData[] = array_merge(
                    Store::factory()->make()->toArray(),
                    [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
            DB::table('stores')->insert($storeData);

            $storeIds = Store::orderByDesc('id')->limit(STORES_LOT)->pluck('id')->toArray();
            foreach ($storeIds as $storeId) {
                $packageData = [];
                for ($k = 0; $k < PACKAGES_PER_STORE; $k++) {
                    $packageData[] = array_merge(
                        Package::factory()->make()->toArray(),
                        [
                            'commune_id' => $communeIds[array_rand($communeIds)],
                            'delivery_type_id' => $deliveryTypeIds[array_rand($deliveryTypeIds)],
                            'status_id' => $packageStatusIds[array_rand($packageStatusIds)],
                            'store_id' => $storeId,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    );
                }
                DB::table('packages')->insert($packageData);
            }
        }
    }
}
