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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->char('kode', 50);
            $table->bigInteger('barang_category_id');
            $table->bigInteger('barang_sub_category_id');
            $table->bigInteger('jenis_kain_id');
            $table->bigInteger('tipe_kain_id');
            $table->bigInteger('warna_id');
            $table->bigInteger('barang_bagian_id');
            $table->bigInteger('barang_gramasi_id');
            $table->bigInteger('barang_lebar_id');
            $table->bigInteger('barang_corak_id');
            $table->bigInteger('barang_satuan_id');
            $table->string('nama')->nullable();
            $table->char('jenis_berat', 35)->nullable();
            $table->string('berat', 15)->nullable();
            $table->integer('qty')->nullable();
            $table->integer('harga_beli')->nullable();
            $table->integer('harga_pokok')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->char('jenis_barang', 15)->nullable();
            $table->char('status_kode', 8)->nullable();
            $table->char('status_barang', 8)->nullable();
            $table->char('status_jual', 8)->nullable();
            $table->char('jenis', 15)->nullable();
            $table->char('barcode_pabrik', 50)->nullable();
            $table->char('kode_roll', 50)->nullable();
            $table->char('nomor_lot', 50)->nullable();
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
        Schema::dropIfExists('barang');
    }
};
