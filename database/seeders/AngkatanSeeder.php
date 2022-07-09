<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Angkatan;

class AngkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Angkatan::updateOrCreate(
            ['id' => 1], 
            [
                'code' => '2020', 
                'entry_year' => '2020', 
                'name' => 'Angkatan 2020',
                'dsp_cost' => '3500000',
                'spp_cost' => '50000'
            ]
        );

        Angkatan::updateOrCreate(
            ['id' => 2], 
            [
                'code' => '2021', 
                'entry_year' => '2021',
                'name' => 'Angkatan 2021',
                'dsp_cost' => '3500000',
                'spp_cost' => '75000'
            ]
        );

        Angkatan::updateOrCreate(
            ['id' => 3], 
            [
                'code' => '2022', 
                'entry_year' => '2022',
                'name' => 'Angkatan 2022',
                'dsp_cost' => '3500000',
                'spp_cost' => '100000'
            ]
        );
    }
}
