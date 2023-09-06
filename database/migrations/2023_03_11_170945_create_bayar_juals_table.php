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
        Schema::create('bayar_juals', function (Blueprint $table) {
            $table->id();
            $table->string('no_faktur');
            $table->integer('invoice_jual_id');
            $table->date('tgl_bayar');
            $table->string('jenis_bayar');
            $table->integer('jml_bayar');
            $table->string('keterangan')->nullable();
            $table->integer('deposit')->nullable()->default('0');
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
        Schema::dropIfExists('bayar_juals');
    }
};
