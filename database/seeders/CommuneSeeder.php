<?php

namespace Database\Seeders;

use App\Models\Commune;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommuneSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Dakar' => [
                'Plateau',
                'Medina',
                'Gueule Tapee',
                'Fann Point E',
                'Hann Bel Air',
                'Yoff',
                'Ngor',
                'Ouakam',
                'Camberene',
            ],
            'Pikine' => [
                'Pikine Nord',
                'Pikine Est',
                'Pikine Ouest',
                'Thiaroye Sur Mer',
                'Yeumbeul Nord',
                'Yeumbeul Sud',
                'Guinaw Rails Nord',
                'Guinaw Rails Sud',
            ],
            'Guediawaye' => [
                'Golf Sud',
                'Medina Gounass',
                'Ndiareme',
                'Sam Notaire',
                'Wakhinane Nimzatt',
            ],
            'Rufisque' => [
                'Rufisque Est',
                'Rufisque Ouest',
                'Rufisque Nord',
                'Bargny',
                'Diamniadio',
                'Sangalkam',
                'Yene',
            ],
            'Keur Massar' => [
                'Keur Massar',
                'Malika',
                'Ndiareme Limamoulaye',
                'Jaxaay',
                'Tivaouane Peulh',
            ],
            'Diourbel' => [
                'Diourbel',
                'Ndindy',
                'Ngoye',
            ],
            'Bambey' => [
                'Bambey',
                'Dinguiraye',
                'Ngogom',
            ],
            'Mbacke' => [
                'Mbacke',
                'Touba',
                'Dalla Ngabou',
            ],
            'Fatick' => [
                'Fatick',
                'Niakhar',
                'Diohine',
            ],
            'Foundiougne' => [
                'Foundiougne',
                'Djilor',
                'Toubacouta',
                'Sokone',
            ],
            'Gossas' => [
                'Gossas',
                'Colobane',
                'Ouadiour',
            ],
            'Kaffrine' => [
                'Kaffrine',
                'Gniby',
                'Kahi',
            ],
            'Birkelane' => [
                'Birkelane',
                'Keur Mboucki',
                'Mabo',
            ],
            'Malem Hodar' => [
                'Malem Hodar',
                'Darou Minam',
                'Nguick',
            ],
            'Koungheul' => [
                'Koungheul',
                'Ida Mouride',
                'Touba Toul',
                'Maka Yop',
            ],
            'Kaolack' => [
                'Kaolack',
                'Ndoffane',
                'Ndiaffate',
                'Latmingue',
            ],
            'Guinguineo' => [
                'Guinguineo',
                'Fass',
                'Mboss',
            ],
            'Nioro du Rip' => [
                'Nioro du Rip',
                'Keur Madiabel',
                'Porokhane',
                'Paoskoto',
            ],
            'Kedougou' => [
                'Kedougou',
                'Bandafassi',
                'Dindefelo',
            ],
            'Salemata' => [
                'Salemata',
                'Ethiolo',
                'Dakateli',
            ],
            'Saraya' => [
                'Saraya',
                'Sabodala',
                'Khossanto',
            ],
            'Kolda' => [
                'Kolda',
                'Dabo',
                'Mampatim',
                'Sare Yoba Diega',
            ],
            'Velingara' => [
                'Velingara',
                'Kounkane',
                'Diaobe Kabendou',
                'Bonconto',
            ],
            'Medina Yoro Foulah' => [
                'Medina Yoro Foulah',
                'Pata',
                'Ndorna',
            ],
            'Louga' => [
                'Louga',
                'Darou Mousty',
                'Ndiagne',
            ],
            'Kebemer' => [
                'Kebemer',
                'Ndande',
                'Sagatta Gueth',
            ],
            'Linguere' => [
                'Linguere',
                'Dahra',
                'Yang Yang',
            ],
            'Matam' => [
                'Matam',
                'Agnam Civol',
                'Ourosogui',
                'Thilogne',
            ],
            'Kanel' => [
                'Kanel',
                'Semme',
                'Waounde',
                'Dembancane',
            ],
            'Ranerou Ferlo' => [
                'Ranerou',
                'Loumbol Ferlo',
                'Velingara Ferlo',
            ],
            'Saint-Louis' => [
                'Saint-Louis',
                'Gandon',
                'Mpal',
                'Ndiebene Gandiol',
            ],
            'Dagana' => [
                'Dagana',
                'Richard Toll',
                'Rosso Senegal',
                'Mbane',
            ],
            'Podor' => [
                'Podor',
                'Thille Boubacar',
                'Cas Cas',
                'Mboumba',
            ],
            'Sedhiou' => [
                'Sedhiou',
                'Marsassoum',
                'Djibabouya',
                'Bambaly',
            ],
            'Bounkiling' => [
                'Bounkiling',
                'Madina Wandifa',
                'Ndiamacouta',
            ],
            'Goudomp' => [
                'Goudomp',
                'Diattacounda',
                'Samine',
                'Tanaff',
            ],
            'Tambacounda' => [
                'Tambacounda',
                'Makacoulibantang',
                'Missirah',
                'Sinthian Koundara',
            ],
            'Bakel' => [
                'Bakel',
                'Diawara',
                'Moudery',
            ],
            'Goudiry' => [
                'Goudiry',
                'Kothiary',
                'Bala',
                'Koar',
            ],
            'Koumpentoum' => [
                'Koumpentoum',
                'Kahene',
                'Passy',
                'Bamba Thialene',
            ],
            'Thies' => [
                'Thies Est',
                'Thies Nord',
                'Thies Ouest',
                'Khombole',
                'Notto',
            ],
            'Mbour' => [
                'Mbour',
                'Saly',
                'Ngaparou',
                'Joal Fadiouth',
                'Somone',
                'Warang',
            ],
            'Tivaouane' => [
                'Tivaouane',
                'Mboro',
                'Meouane',
                'Pire Goureye',
                'Merina Dakhar',
            ],
            'Ziguinchor' => [
                'Ziguinchor',
                'Niaguis',
                'Boutoute',
                'Enampore',
            ],
            'Bignona' => [
                'Bignona',
                'Thionck Essyl',
                'Tenghory',
                'Kataba I',
                'Sindian',
            ],
            'Oussouye' => [
                'Oussouye',
                'Cap Skiring',
                'Mlomp',
                'Diembering',
            ],
        ];

        foreach ($departments as $departmentName => $communes) {
            $department = Department::query()
                ->where('name', $departmentName)
                ->firstOrFail();

            foreach ($communes as $commune) {
                Commune::query()->updateOrCreate(
                    [
                        'department_id' => $department->id,
                        'name' => $commune,
                    ],
                    [
                        'name' => $commune,
                    ]
                );
            }
        }
    }
}

