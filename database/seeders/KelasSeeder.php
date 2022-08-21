<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kelas::updateOrCreate(
            ['id' => 1],
            [
                'code' => 'Kelas 10',
                'name' => 'Kelas 10'
            ]
        );

        Kelas::updateOrCreate(
            ['id' => 2],
            [
                'code' => 'Kelas 11',
                'name' => 'TKelas 11'
            ]
        );

        Kelas::updateOrCreate(
            ['id' => 3],
            [
                'code' => 'Kelas 12',
                'name' => 'TKelas 12'
            ]
        );
    }
}
