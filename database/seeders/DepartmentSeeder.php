<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            'DKR' => ['Dakar', 'Pikine', 'Guediawaye', 'Rufisque', 'Keur Massar'],
            'DBL' => ['Diourbel', 'Bambey', 'Mbacke'],
            'FTK' => ['Fatick', 'Foundiougne', 'Gossas'],
            'KAF' => ['Kaffrine', 'Birkelane', 'Malem Hodar', 'Koungheul'],
            'KLC' => ['Kaolack', 'Guinguineo', 'Nioro du Rip'],
            'KDG' => ['Kedougou', 'Salemata', 'Saraya'],
            'KLD' => ['Kolda', 'Velingara', 'Medina Yoro Foulah'],
            'LGA' => ['Louga', 'Kebemer', 'Linguere'],
            'MTM' => ['Matam', 'Kanel', 'Ranerou Ferlo'],
            'STL' => ['Saint-Louis', 'Dagana', 'Podor'],
            'SDH' => ['Sedhiou', 'Bounkiling', 'Goudomp'],
            'TBC' => ['Tambacounda', 'Bakel', 'Goudiry', 'Koumpentoum'],
            'THS' => ['Thies', 'Mbour', 'Tivaouane'],
            'ZIG' => ['Ziguinchor', 'Bignona', 'Oussouye'],
        ];

        foreach ($regions as $code => $departments) {
            $region = Region::query()->where('code', $code)->firstOrFail();

            foreach ($departments as $department) {
                Department::query()->updateOrCreate(
                    [
                        'region_id' => $region->id,
                        'name' => $department,
                    ],
                    [
                        'name' => $department,
                    ]
                );
            }
        }
    }
}

