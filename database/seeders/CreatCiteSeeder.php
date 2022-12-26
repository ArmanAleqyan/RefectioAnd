<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\City;

class CreatCiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(base_path('cities.json')), true);
        $region = null;

     foreach ($data as $city){
         $city = City::create(['name' => $city['city']]);
     }
    }
}
