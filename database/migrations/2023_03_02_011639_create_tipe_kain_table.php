<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipe_kain', function (Blueprint $table) {
            $table->id();
            $table->char('kode', 50);
            $table->integer('jenis_kain_id');
            $table->integer('warna_id');
            $table->integer('barang_lebar_id');
            $table->integer('barang_gramasi_id');
            $table->integer('barang_satuan_id');
            $table->char('set', 10);
            $table->string('nama', 100);
            $table->integer('harga_default')->default(0);
            $table->integer('harga_tambahan')->default(0);
            $table->integer('harga_final')->default(0);
            $table->string('keterangan', 255)->nullable();
            $table->char('status', 50);
            $table->string('gambar', 255)->nullable();
            $table->timestamps();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipe_kain');
    }
};
