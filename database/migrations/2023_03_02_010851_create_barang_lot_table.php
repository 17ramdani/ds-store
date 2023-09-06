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
        Schema::create('barang_lot', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('po_id')->default(0);
            $table->bigInteger('penjualan_id');
            $table->char('jenis_lot', 50)->nullable();
            $table->char('kode_lot', 50)->nullable();
            $table->char('nama_lot', 50)->nullable();
            $table->char('satuan', 50)->nullable();
            $table->char('barcode', 50)->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->integer('stok_awal')->nullable();
            $table->integer('stok_akhir')->nullable();
            $table->integer('stok_min')->nullable();
            $table->integer('harga_pokok')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->integer('harga_jual_ppn')->nullable();
            $table->integer('nilai_stok_akhir')->nullable();
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
        Schema::dropIfExists('barang_lot');
    }
};
