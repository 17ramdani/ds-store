<?php

namespace Database\Seeders;

use App\Models\Barang\BarangGramasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangGramasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BarangGramasi::truncate();

        BarangGramasi::upsert(
            [
                ['kode' => 'GRM.1', 'nama' => '260-270'],
                ['kode' => 'GRM.2', 'nama' => '230-240'],
                ['kode' => 'GRM.3', 'nama' => '150-160'],
                ['kode' => 'GRM.4', 'nama' => '170-180'],
                ['kode' => 'GRM.5', 'nama' => '240-260'],
                ['kode' => 'GRM.6', 'nama' => '190-200'],
                ['kode' => 'GRM.7', 'nama' => '130-140'],
                ['kode' => 'GRM.8', 'nama' => '160-180'],
                ['kode' => 'GRM.9', 'nama' => '140-150'],
                ['kode' => 'GRM.10', 'nama' => '120-130'],
                ['kode' => 'GRM.11', 'nama' => '200-210'],
                ['kode' => 'GRM.12', 'nama' => '270-280'],
                ['kode' => 'GRM.13', 'nama' => '210-220'],
                ['kode' => 'GRM.14', 'nama' => '160-170'],
                ['kode' => 'GRM.15', 'nama' => '110-120'],
                ['kode' => 'GRM.16', 'nama' => '200'],
                ['kode' => 'GRM.17', 'nama' => '260-280'],
                ['kode' => 'GRM.18', 'nama' => '250-260'],
                ['kode' => 'GRM.19', 'nama' => '210-220 '],
                ['kode' => 'GRM.20', 'nama' => '240-250'],
                ['kode' => 'GRM.21', 'nama' => '110-120 '],
                ['kode' => 'GRM.22', 'nama' => '160-170 '],
                ['kode' => 'GRM.23', 'nama' => '100-110'],
                ['kode' => 'GRM.24', 'nama' => '155'],
                ['kode' => 'GRM.25', 'nama' => '185'],
                ['kode' => 'GRM.26', 'nama' => 'YARD'],
                ['kode' => 'GRM.27', 'nama' => 'METER'],
                ['kode' => 'GRM.28', 'nama' => '180-190']
            ],
            ['kode'],
            ['nama']
        );
    }
}
