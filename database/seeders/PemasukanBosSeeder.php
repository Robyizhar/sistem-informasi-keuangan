<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PemasukanBos;
use App\Models\PemasukanBosDetail;

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
                'name'           => 'Pemasukan Tahun 2022',
                'type'           => 'REGULER',
                'year'           => '2022',
            ]
        );

        PemasukanBosDetail::updateOrCreate(['id'                    => 1],[
            'id'                    => 1,
            'm_pemasukan_bos_id'    => 1,
            'name'                  => 'Pemasukan Tahun 2022 Tahap 1',
            'received_funds'        => 900000000,
            'start_date'            => '2022-01-01',
            'end_date'              => '2022-04-29',
        ]);

        PemasukanBosDetail::updateOrCreate(['id'                    => 2],[
            'id'                    => 2,
            'm_pemasukan_bos_id'    => 1,
            'name'                  => 'Pemasukan Tahun 2022 Tahap 2',
            'received_funds'        => 900000000,
            'start_date'            => '2022-05-01',
            'end_date'              => '2022-08-31',
        ]);

        PemasukanBosDetail::updateOrCreate(['id'                    => 3],[

            'm_pemasukan_bos_id'    => 1,
            'name'                  => 'Pemasukan Tahun 2022 Tahap 3',
            'received_funds'        => 750000000,
            'start_date'            => '2022-09-01',
            'end_date'              => '2022-12-31',
        ]);

    }
}
