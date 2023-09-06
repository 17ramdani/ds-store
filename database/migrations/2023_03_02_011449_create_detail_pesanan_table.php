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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pesanan_id');
            $table->integer('tipe_kain_id')->nullable()->default(0);
            $table->integer('qty')->nullable()->default(0);
            $table->integer('qty_act')->nullable()->default(0);
            $table->integer('harga')->nullable()->default(0);
            $table->string('satuan')->nullable();
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
        Schema::dropIfExists('detail_pesanan');
    }
};
