<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $bloodGroups = [
            'A+',
            'A-',
            'B+',
            'B-',
            'O+',
            'O-',
            'AB+',
            'AB-',
        ];

        foreach ($bloodGroups as $group) {
            BloodGroup::firstOrCreate([
                'group_name' => $group,
            ]);
        }

        $provincesWithCities = [
            'Alberta' => [
                'Calgary',
                'Edmonton',
                'Red Deer',
                'Lethbridge',
                'Medicine Hat',
                'Airdrie',
                'Grande Prairie',
                'St. Albert',
                'Fort McMurray',
                'Spruce Grove',
                'Leduc',
                'Okotoks',
                'Cochrane',
                'Brooks',
                'Camrose',
                'Lloydminster',
            ],

            'British Columbia' => [
                'Vancouver',
                'Victoria',
                'Surrey',
                'Burnaby',
                'Richmond',
                'Kelowna',
                'Abbotsford',
                'Coquitlam',
                'Nanaimo',
                'Kamloops',
                'Langley',
                'Prince George',
                'Delta',
                'Chilliwack',
                'Vernon',
                'Penticton',
                'Maple Ridge',
                'New Westminster',
                'North Vancouver',
                'West Vancouver',
            ],

            'Manitoba' => [
                'Winnipeg',
                'Brandon',
                'Steinbach',
                'Thompson',
                'Portage la Prairie',
                'Winkler',
                'Selkirk',
                'Morden',
                'Dauphin',
                'The Pas',
                'Flin Flon',
            ],

            'New Brunswick' => [
                'Moncton',
                'Saint John',
                'Fredericton',
                'Dieppe',
                'Miramichi',
                'Edmundston',
                'Bathurst',
                'Campbellton',
                'Oromocto',
                'Sackville',
            ],

            'Newfoundland and Labrador' => [
                "St. John's",
                'Mount Pearl',
                'Corner Brook',
                'Conception Bay South',
                'Grand Falls-Windsor',
                'Gander',
                'Paradise',
                'Labrador City',
                'Happy Valley-Goose Bay',
                'Carbonear',
            ],

            'Northwest Territories' => [
                'Yellowknife',
                'Hay River',
                'Inuvik',
                'Fort Smith',
                'Behchoko',
                'Fort Simpson',
                'Tuktoyaktuk',
                'Norman Wells',
            ],

            'Nova Scotia' => [
                'Halifax',
                'Sydney',
                'Dartmouth',
                'Truro',
                'New Glasgow',
                'Glace Bay',
                'Kentville',
                'Amherst',
                'Bridgewater',
                'Yarmouth',
                'Antigonish',
                'Wolfville',
            ],

            'Nunavut' => [
                'Iqaluit',
                'Rankin Inlet',
                'Arviat',
                'Baker Lake',
                'Cambridge Bay',
                'Pangnirtung',
                'Pond Inlet',
                'Kugluktuk',
                'Igloolik',
            ],

            'Ontario' => [
                'Toronto',
                'Ottawa',
                'Mississauga',
                'Brampton',
                'Hamilton',
                'London',
                'Markham',
                'Vaughan',
                'Kitchener',
                'Windsor',
                'Richmond Hill',
                'Oakville',
                'Burlington',
                'Greater Sudbury',
                'Oshawa',
                'Barrie',
                'St. Catharines',
                'Cambridge',
                'Kingston',
                'Guelph',
                'Thunder Bay',
                'Waterloo',
                'Brantford',
                'Peterborough',
                'Sarnia',
                'Niagara Falls',
                'North Bay',
                'Timmins',
                'Cornwall',
                'Orillia',
            ],

            'Prince Edward Island' => [
                'Charlottetown',
                'Summerside',
                'Stratford',
                'Cornwall',
                'Montague',
                'Kensington',
                'Souris',
                'Alberton',
            ],

            'Quebec' => [
                'Montreal',
                'Quebec City',
                'Laval',
                'Gatineau',
                'Longueuil',
                'Sherbrooke',
                'Saguenay',
                'Levis',
                'Trois-Rivieres',
                'Terrebonne',
                'Saint-Jean-sur-Richelieu',
                'Repentigny',
                'Brossard',
                'Drummondville',
                'Saint-Jerome',
                'Granby',
                'Blainville',
                'Saint-Hyacinthe',
                'Shawinigan',
                'Rimouski',
            ],

            'Saskatchewan' => [
                'Regina',
                'Saskatoon',
                'Moose Jaw',
                'Prince Albert',
                'Yorkton',
                'Swift Current',
                'North Battleford',
                'Estevan',
                'Weyburn',
                'Lloydminster',
                'Melfort',
                'Humboldt',
                'Meadow Lake',
                'Martensville',
                'Warman',
            ],

            'Yukon' => [
                'Whitehorse',
                'Dawson City',
                'Watson Lake',
                'Haines Junction',
                'Mayo',
                'Faro',
                'Carmacks',
            ],
        ];

        foreach ($provincesWithCities as $provinceName => $cityNames) {
            $province = State::firstOrCreate([
                'name' => $provinceName,
            ]);

            foreach ($cityNames as $cityName) {
                City::firstOrCreate([
                    'name' => $cityName,
                    'state_id' => $province->id,
                ]);
            }
        }

        User::updateOrCreate(
            ['email' => 'admin77@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('asdfasdf'),
                'email_verified_at' => now(),
            ]
        );
    }
}
