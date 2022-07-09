<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jurusan::updateOrCreate(
            ['id' => 1], 
            [
                'code' => 'MM', 
                'name' => 'Multimedia'
            ]
        );

        Jurusan::updateOrCreate(
            ['id' => 2], 
            [
                'code' => 'TKJ',
                'name' => 'Teknik Komputer Dan Jaringan'
            ]
        );
    }
}
