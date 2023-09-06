<?php

namespace Database\Seeders;

use App\Models\Barang\BarangLebar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangLebarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BarangLebar::truncate();

        BarangLebar::upsert(
            [
                ['kode' => 'LB.1', 'keterangan' => '72'],
                ['kode' => 'LB.2', 'keterangan' => '36'],
                ['kode' => 'LB.3', 'keterangan' => '42'],
                ['kode' => 'LB.4', 'keterangan' => '40'],
                ['kode' => 'LB.5', 'keterangan' => '45'],
                ['kode' => 'LB.6', 'keterangan' => '66'],
                ['kode' => 'LB.7', 'keterangan' => '70'],
                ['kode' => 'LB.8', 'keterangan' => '60'],
                ['kode' => 'LB.9', 'keterangan' => '56'],
                ['kode' => 'LB.10', 'keterangan' => '52'],
                ['kode' => 'LB.11', 'keterangan' => '100'],
                ['kode' => 'LB.12', 'keterangan' => '50-60'],
                ['kode' => 'LB.13', 'keterangan' => '200'],
                ['kode' => 'LB.14', 'keterangan' => '200-400'],
                ['kode' => 'LB.15', 'keterangan' => '300'],
                ['kode' => 'LB.16', 'keterangan' => '301'],
                ['kode' => 'LB.17', 'keterangan' => '80']
            ],
            ['kode'],
            ['keterangan']
        );
    }
}
