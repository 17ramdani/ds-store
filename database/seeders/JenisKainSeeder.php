<?php

namespace Database\Seeders;

use App\Models\Barang\JenisKain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisKainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisKain::truncate();

        JenisKain::upsert([
            ['kode' => 'JK.1', 'nama' => 'A.COTTON SINGLE KNIT', 'gambar' => 'https://duniasandang.com/wp-content/uploads/2022/01/combed-30s-dunia-sandang-1.jpg', 'keterangan' => 'Katalog 149 warna cotton terbaru Dunia Sandang, terdiri dari Cotton Combed,  Cotton Carded dan Misty', 'katalog' => 'https://drive.google.com/file/d/1Kdf4ki0h0-YgiIr1xMQaQZbzjpcpTNlU/view?usp=share_link'],
            ['kode' => 'JK.2', 'nama' => 'B.MISTY SINGLE KNIT', 'gambar' => 'https://duniasandang.com/wp-content/uploads/2022/01/combed-30s-misty-dunia-sandang.jpg', 'keterangan' => 'Bahan khas dengan kesan warna berkabut seperti two tone dengan perbedaan warna yang lebih menonjol', 'katalog' => 'https://drive.google.com/file/d/1QLzo6NMmKcIQxyZ_3_NRpnuR7oabg8u4/view?usp=sharing'],
            ['kode' => 'JK.3', 'nama' => 'D.LACOSTE', 'gambar' => 'https://duniasandang.com/wp-content/uploads/2022/01/lacoste-dunia-sandang.jpg', 'keterangan' => 'Jenis kain anyaman berpori besar yang biasanya digunakan untuk bahan kaos polo, kerah, dan wangki.', 'katalog' => 'https://drive.google.com/file/d/1Z_gav6ElxyCKX4_JV_E45rTdP4yrD8Lw/view?usp=share_link'],
            ['kode' => 'JK.4', 'nama' => 'E.FLEECE', 'gambar' => 'https://duniasandang.com/wp-content/uploads/2022/01/fleece-dunia-sandang.jpg', 'keterangan' => 'Kain dengan lapisan seperti bulu di bagian belakangnya yang biasanya  digunakan sebagai bahan jaket/sweater', 'katalog' => 'https://drive.google.com/file/d/11JSmnEWkzmS12RGsrpVRXbK2khwMZXXR/view?usp=sharing'],
            ['kode' => 'JK.5', 'nama' => 'F.BABYTERRY', 'gambar' => 'https://duniasandang.com/wp-content/uploads/2022/01/baby-terry-dunia-sandang-1.jpg', 'keterangan' => 'Dengan tekstur yang lembut, jenis kain Babyterry cocok untuk dijadikan bahan untuk pakaian hangat seperti jaket, hoody, atau sweater', 'katalog' => '#'],
            ['kode' => 'JK.6', 'nama' => 'G.DRYFIT', 'gambar' => 'https://duniasandang.com/wp-content/uploads/2022/01/dryfit-dunia-sandang.jpg', 'keterangan' => 'Teksturnya yang lentur menjadikan bahan ini cocok untuk digunakan dalam pembuatan Jersey baik itu jersey bola, tenis, basket, hingga voli.', 'katalog' => '#'],
            ['kode' => 'JK.7', 'nama' => 'H.POLYESTER', 'gambar' => 'https://duniasandang.com/wp-content/uploads/2022/01/polyester-dunia-sandang.jpg', 'keterangan' => 'Jenis kain dengan serat polyester yang biasa digunakan untuk pakaian outdoor seperti jaket parka, tenda dan lain-lain', 'katalog' => '#'],
            ['kode' => 'JK.8', 'nama' => 'I.MERINO', 'gambar' => 'https://duniasandang.com/wp-content/uploads/2022/01/merino-dunia-sandang.jpg', 'keterangan' => 'Jenis wool terbaik dengan tekstur yang sangat lembut, Cocok untuk menjadi bahan kaos, jaket, atau selimut', 'katalog' => '#'],
            ['kode' => 'JK.9', 'nama' => 'J.WOVEN', 'gambar' => 'https://duniasandang.com/wp-content/uploads/2022/01/woven-dunia-sandang.jpg', 'keterangan' => 'Jenis kain woven adalah jenis kain yang diperoleh dengan cara menenun yang biasanya digunakan untuk bahan kemeja dan celana panjang', 'katalog' => '#']

        ], ['kode'], ['nama', 'gambar', 'keterangan', 'katalog']);
    }
}
