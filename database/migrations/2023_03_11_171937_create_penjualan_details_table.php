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
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('barang_lot_id');
            $table->integer('qty');
            $table->integer('total_harga');
            $table->integer('total_harga_ppn');
            $table->integer('disc');
            $table->string('status')->nullable();
            $table->timestamps();
            $table->integer('created_by')->default('0');
            $table->integer('updated_by')->default('0');
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
        Schema::dropIfExists('penjualan_details');
    }
};
