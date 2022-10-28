<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PemasukanBos;

class PemasukanBosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PemasukanBos::updateOrCreate(
            ['id' => 1],
            [
                'year'           => '2022',
                'type'           => 'REGULER',
                'step'           => '1',
                'received_funds' => 900000000,
            ]
        );

        PemasukanBos::updateOrCreate(
            ['id' => 2],
            [
                'year'           => '2022',
                'type'           => 'REGULER',
                'step'           => '2',
                'received_funds' => 900000000,
            ]
        );

        PemasukanBos::updateOrCreate(
            ['id' => 3],
            [
                'year'           => '2022',
                'type'           => 'REGULER',
                'step'           => '3',
                'received_funds' => 750000000,
            ]
        );
    }
}
