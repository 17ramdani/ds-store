<?php

namespace Database\Seeders;

use App\Models\Barang\BarangSatuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BarangSatuan::truncate();

        BarangSatuan::upsert(
            [
                ['kode' => 'STN.1', 'keterangan' => 'KG'],
                ['kode' => 'STN.2', 'keterangan' => 'ROLL'],
                ['kode' => 'STN.3', 'keterangan' => 'METER'],
                ['kode' => 'STN.4', 'keterangan' => 'YARD']
            ],
            ['kode'],
            ['keterangan']
        );
    }
}
