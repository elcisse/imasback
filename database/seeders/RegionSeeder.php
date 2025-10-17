<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['region' => 'Dakar', 'code' => 'DKR'],
            ['region' => 'Diourbel', 'code' => 'DBL'],
            ['region' => 'Fatick', 'code' => 'FTK'],
            ['region' => 'Kaffrine', 'code' => 'KAF'],
            ['region' => 'Kaolack', 'code' => 'KLC'],
            ['region' => 'Kedougou', 'code' => 'KDG'],
            ['region' => 'Kolda', 'code' => 'KLD'],
            ['region' => 'Louga', 'code' => 'LGA'],
            ['region' => 'Matam', 'code' => 'MTM'],
            ['region' => 'Saint-Louis', 'code' => 'STL'],
            ['region' => 'Sedhiou', 'code' => 'SDH'],
            ['region' => 'Tambacounda', 'code' => 'TBC'],
            ['region' => 'Thies', 'code' => 'THS'],
            ['region' => 'Ziguinchor', 'code' => 'ZIG'],
        ];

        foreach ($regions as $region) {
            Region::query()->updateOrCreate(
                ['code' => $region['code']],
                ['region' => $region['region'], 'code' => $region['code']]
            );
        }
    }
}
