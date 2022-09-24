<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GolonganRkas;
use App\Models\SubGolonganRkas;
use DB;

class GolRkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_golongan_rkas')->delete();
        DB::table('m_sub_golongan_rkas')->delete();

        $golongans = [
            [
                'name' => 'UANG LEMBUR',
                'sub_golongan' => [
                    'Uang Lembur PNS',
                    'Uang Lembur Non PNS'
                ]
            ],
            [
                'name' => 'Honorarium Pengelolaan Dana BOS',
                'sub_golongan' => [
                    'Insentif bagi bendahara dalam rangka penyusunan laporan BOS'
                ]
            ],
            [
                'name' => 'Honorarium Bulanan Guru Honorer dan Tenaga Kependidikan Honorer',
                'sub_golongan' => [
                    'Guru Honorer',
                    'Pegawai Administrasi (termasuk administrasi BOS untuk SD)',
                    'Pegawai Perpustakaan dan/atau Laboratorium',
                    'Penjaga Sekolah',
                    'Satpam',
                    'Pegawai Kebersihan',
                    'Honor jam mengajar tambahan di luar jam mengajar',
                    'Honor koreksi ujian sekolah',
                    'Honor penyusunan rapor siswa',
                    'Honorarium supervisi Kepala Sekolah dan Wakil Kepala Sekolah',
                    'Honorarium Tatap muka di sekolah induk.oleh Guru Bina',
                    'Honorarium Pembimbingan di TKB.oleh Guru Pamong',
                    'Honorarium Petugas Tata Usaha/Administrasi ketatausahaan (1 Orang)',
                    'Honorarium Pengelola TKB Mandiri (Pengelolaan kegiatan pembelajaran)'
                ]
            ],
            [
                'name' => 'Belanja Barang dan Jasa',
                'sub_golongan' => [
                    'Belanja Bahan Pakai Habis',
                    'Belanja Bahan/ Material',
                    'Belanja Jasa Kantor',
                    'Belanja Cetak dan Penggandaan',
                    'Belanja Makanan dan Minuman',
                    'Belanja Pakaian Khusus untuk inventaris sekolah',
                    'Belanja Perjalanan Dinas',
                    'Belanja pemberian bantuan siswa miskin',
                    'Belanja Pemeliharaan',
                    'Belanja Sewa Perlengkapan dan Peralatan Kantor'
                ]
            ],
            [
                'name' => 'BELANJA MODAL (INVESTASI)',
                'sub_golongan' => [
                    'Belanja Modal Pengadaan Alat-alat Angkutan Darat Tidak Bermotor',
                    'Belanja Modal Pengadaan Peralatan Kantor',
                    'Belanja Modal Pengadaan Perlengkapan Kantor',
                    'Belanja Modal Pengadaan Komputer',
                    'Belanja Modal Pengadaan Meubelair',
                    'Belanja Modal Pengadaan Instalasi Listrik dan telepon'.
                    'Belanja Modal Pengadaan Buku/Kepustakaan',
                    'Belanja Modal Pengadaan Alat-alat Studio (Alat peraga)',
                    'Belanja Modal Pengadaan Alat-alat Komunikasi',
                    'Belanja Modal Pengadaan Alat-alat Laboratorium',
                    'Belanja Modal Pengadaan Peralatan/Perlengkapan Kesenian,Olahraga dan Kesehatan',
                    'Belanja Modal Pengadaan alat permainan edukatif (APE)/ inklusi'
                ]
            ]
        ];
        $index = 1;
        foreach ($golongans as $golongan) {
            $gol = GolonganRkas::create([
                'code' => 'GOL-'.$index,
                'name' => $golongan['name']
            ]);
            if (isset($golongan['sub_golongan']) && !empty($golongan['sub_golongan'])) {
                for ($i=0; $i < sizeOf($golongan['sub_golongan']); $i++) {
                    SubGolonganRkas::create([
                        'golongan_rkas_id' => $gol->id,
                        'name' => $golongan['sub_golongan'][$i]
                    ]);
                }
            }
            $index++;
        }

    }
}
